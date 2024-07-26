# Tweedekamer Agenda


Once, as a job application assignment, I had to create a calendar that had to retrieve calendar items from the House of Representatives website with the use of web crawling. By selecting the right divs and collecting the data.

It is currently no longer recommended to use the web crawling function since tweedekamer.nl can block you if there are too many requests.

Clone the project
```
git clone git@github.com:Gi0vanniM/TweedeKamer-Agenda.git
```

CD into the project
```
cd TweedeKamer-Agenda
```

Install the composer dependencies
```
composer install
```

Install the npm dependencies
```
npm install
```

Build the frontend
```
npm run build
```

## Configs
Change the name of the '.env.example' file to '.env'.
In the env file set your database connection and the url of the application.

### Database
Migrate your database
```
php artisan migrate --seed
```

## Agenda webscraper
To get the webscraper working you have to add the following cron
```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```
Or use the following command
```
php artisan schedule:work
```
This command will keep running until you stop it yourself.

You can also use the following command to manually run the webscraper.
```
php artisan scrape:agenda
```

## Running locally
To run the application locally, run the following command.
```
php artisan serve
```

Visit the application

By default, you can visit the application via: [http://127.0.0.1:8000](http://127.0.0.1:8000)

You will probably see a screen that says your app_key is missing, click on "GENERATE APP KEY" and then on "Refresh now".

You can now create an account by clicking "Register".
Or use the default admin account if you seeded the database whilst migrating (admin@example.com, password)

Now you can use application.
