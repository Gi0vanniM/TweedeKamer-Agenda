<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AgendaItem;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Symfony\Component\BrowserKit\HttpBrowser;
use Illuminate\Support\Facades\Log;

class ScrapeAgenda extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:agenda';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape the Tweede Kamer agenda items';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('Started scrape agenda job');

        // get today
        $startDate = new Carbon();
        // set end date to be 30 days from now
        $endDate = $startDate->copy()->addDays(30);
        // get all days between start and end
        $period = new CarbonPeriod($startDate, $endDate);

        // iterate over the days
        foreach ($period as $currentDate) {
            $date = $currentDate->format('d-m-Y');

            // set a formatted date for sql
            $formattedDate = (new Carbon($date))->format('Y-m-d');

            // scrape the agenda page
            $client = new HttpBrowser();
            $url = "https://www.tweedekamer.nl/debat_en_vergadering?date=" . $date;

            $page = $client->request('GET', $url);

            // filter, to get all the agenda items
            $page->filter('.tvgids-item')->each(function ($item) use ($date, $formattedDate) {

                // get the id of agenda item
                $href = $item->attr('href');
                $matchId = [];
                preg_match("/id=([0-9a-zA-Z]+)/", $href, $matchId);
                $scrapeId = $matchId[1];

                $agendaItem = null;
                $exists = false;

                // check if scrape id already exists
                if (AgendaItem::where('scraped_id', '=', $scrapeId)->exists()) {
                    $agendaItem = AgendaItem::where('scraped_id', '=', $scrapeId)->first();
                    $exists = true;
                } else {
                    $agendaItem = new AgendaItem();
                    $agendaItem->scraped_id = $scrapeId;
                }

                // set agenda item data
                // set agenda type to 2
                $agendaItem->agenda_type_id = 2;
                // get the title
                $agendaItem->title = $item->filter('.title')->text() ?? null;
                // get the time using regex to match the times
                $matchTime = [];
                preg_match_all("/[0-9]{1,2}:[0-9]{2}/", $item->filter('.time')->text(), $matchTime);
                // set the from date and time
                $agendaItem->from_date = $formattedDate;
                $agendaItem->from_time = $matchTime[0][0] ?? null;
                // set the to date and time
                $agendaItem->to_date = $formattedDate;
                $agendaItem->to_time = $matchTime[0][1] ?? null;
                // get the type
                $agendaItem->type = $item->filter('.type')->text() ?? null;
                // some agenda items don't have commission so check before trying to access
                if ($item->filter('.commission')->count() > 0) {
                    // get the commission
                    $agendaItem->commission = $item->filter('.commission')->text();
                }
                // if exists, update. else, save.
                if ($exists) {
                    $agendaItem->update();
                } else {
                    $agendaItem->save();
                }
            });
        }

        Log::info('Ended scrape agenda job');
    }
}
