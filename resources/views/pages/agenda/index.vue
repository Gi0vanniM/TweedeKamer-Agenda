<script setup lang="ts">
import { defineComponent, onMounted, reactive } from 'vue';
import AgendaDayLinkVue from '@/views/components/agenda-day-link.vue';
import { timeToDec } from '@/helpers/timeToDec';
import { Link } from '@inertiajs/inertia-vue3';
import { isTemplateNode } from '@vue/compiler-core';

const props = defineProps({
    auth: Object,
    week: Object,
    selectedDate: Object,
    prevWeek: String,
    nextWeek: String,
    agendaItems: Object,
})

var todayDate = new Date();
var today:String = String(todayDate.getDate()).padStart(2, '0') + "-" + String(todayDate.getMonth() + 1).padStart(2, '0') + "-" + todayDate.getFullYear();
// widths
var fullTimeWidth = 7200;
var hourWidth = 300;

const data = reactive({
    decTime: 0,
    timeWidth: 0,
    plenaryDebateItems: Array(),
    agendaItemRows: Array(),
})
// set values of reactive variables
data.decTime = timeToDec();
data.timeWidth = data.decTime * hourWidth;

onMounted(() => {
    /**
     * sort out agenda items to be on different rows when needed
     */
    props.agendaItems?.forEach((item:any) => {
        // plenair debates should never be overlapping anyway
        if (item.type == 'Plenair debat') {
            data.plenaryDebateItems.push(item);
        } else {
            // check for overlap
            let index = 0;
            // loop through the already set rows
            let isSet = data.agendaItemRows.some((row:any, i:number, array:Array<Array<Object>>) => {
                
                let overlap = row.some((rowItem:any, i1:number) => {
                    let startA:number = new Date(item.from_date + ' ' + item.from_time).getTime();
                    let endA:number = new Date(item.to_date + ' ' + item.to_time).getTime();
                    let startB:number = new Date(rowItem.from_date + ' ' + rowItem.from_time).getTime();
                    let endB:number = new Date(rowItem.to_date + ' ' + rowItem.to_time).getTime();

                    // console.log('overlap: ', ((startA <= endB) && (endA >= startB)));
                    
                    // if overlap, return true
                    // if ((startA <= endB) && (endA >= startB)) {
                    if ((startA < endB) && (endA > startB)) {
                        return true;
                    }
                });
                // if no overlap, push item
                if (!overlap) {
                    data.agendaItemRows[i].push(item);
                }
                return (!overlap) ? true : false;
            })
            // console.log("isSet: " + isSet);
            if (!isSet) {
                data.agendaItemRows.push([item]);
            }
            // console.log(JSON.parse(JSON.stringify(data.agendaItemRows)));
        }
    });

    if (today === props.selectedDate?.date) {
        // TODO::set scroll to current time
    } else {
        // TODO::set scroll to earliest event
    }
    
    // every 10 seconds, update the timeline progress bar
    setInterval(() => {
        data.decTime = timeToDec();
        data.timeWidth = data.decTime * hourWidth;
    }, 10000);

    var timeline:any = document.getElementById('timeline-container');
    timeline.scrollLeft = 10*300;
})

/**
 * function to get the width of the agenda item in px
 * @param item agendaItem
 */
function getWidth(item:any):string {
    let fromTime = timeToDec(new Date(item.from_date + ' ' + item.from_time));
    let toTime = timeToDec(new Date(item.from_date + ' ' + item.to_time));
    let duration = toTime - fromTime;
    
    return (duration * hourWidth) + 1 + 'px';
}

/**
 * function to get the px length for the left side of the agenda item
 * @param item agendaItem
 */
function getLeft(item:any):string {
    let fromTime = timeToDec(new Date(item.from_date + ' ' + item.from_time));
    return (fromTime * 300)+'px';
}


</script>

<template layout>
    <div class="container mx-auto">

        <div class="flex justify-center">
            <h1 class="">AGENDA</h1>
        </div>

        <div class="">
            <!-- Tabs: < prev. week | mon - sun | next week > -->
            <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 h-16">
                <!-- <ul class="flex flex-wrap h-16"> -->
                <ul class="grid grid-cols-9">
                    <AgendaDayLinkVue :href="'/agenda/' + prevWeek" class="">
                        <span class="block">&lt; Vorige week</span>
                    </AgendaDayLinkVue>
                    <template v-for="day in week">
                        <AgendaDayLinkVue :href="'/agenda/' + day.date" class="" :active="selectedDate?.dayName === day.dayName">
                            <span class="block">{{ day.dayName }}</span>
                            <span class="block">{{ day.dateText }}</span>
                        </AgendaDayLinkVue>
                    </template>
                    <AgendaDayLinkVue :href="'/agenda/' + nextWeek" class="">
                        <span class="block">Volgende week ></span>
                    </AgendaDayLinkVue>
                </ul>
            </div>
        </div>

        <div class="h-10"></div>

        <!-- Hours: 00:00 to 23:00 -->

        <!-- timeline container -->
        <div id="timeline-container" class="w-full relative overflow-x-scroll overflow-y-hidden box-border">

            <!-- timemarker -->
            <div id="timemarker" class="absolute h-full w-px box-border border-l-2 border-black z-20 opacity-30" :style="{'left': data.timeWidth + 'px'}"></div>

            <!-- timeline -->
            <div id="timeline" class="p-0 m-0 relative flex box-border text-black" :style="{'width': fullTimeWidth + 'px'}">
                <template v-for="(n, i) in 24">
                    <div style="width: 300px;">
                        <div id="time-indicator" class="inline-block">{{i}}:00</div>
                    </div>
                </template>
            </div>
            <!-- timeline progress -->
            <div class="p-0 m-0 h-px relative box-border" style="border-bottom: dashed 2px gray;" :style="{'width': fullTimeWidth + 'px'}">
                <div class="border-b-2 border-b-indigo-400" :style="{'width': data.timeWidth + 'px'}"></div>
            </div>
            <!-- timeline grid -->
            <div class="p-0 m-0 absolute box-border text-black" style="height: calc(100% - 30px);" :style="{'width': fullTimeWidth + 'px'}">
                <template v-for="(n, i) in 24">
                    <div class="h-full absolute" :style="{'left': (i*300)+'px'}" style="border-right: solid 1px #cdd2d4;"></div>
                </template>
            </div>
            
            <!-- row -->
            <!-- plenair -->
            <div class="relative p-0 m-0 flex flex-wrap" style="height: 72px; border-top: solid 1px #cdd2d4;" :style="{'width': fullTimeWidth + 'px'}">
                <template v-for="item in data.plenaryDebateItems">
                    <template v-if="item.type == 'Plenair debat'">
                        <div
                            class="absolute h-full bg-blue-100 border-l border-r border-black"
                            :style="{'width': getWidth(item), 'left': getLeft(item)}"
                            style="padding-left: 6px; padding-right: 6px;"
                        >   
                            <div class="m-2">
                                <h1 class="font-bold text-xs truncate">{{ item.title }}</h1>
                                <Link :href="'/agendaitem/edit/'+item.id" class="absolute right-0 top-0 m-2 bg-slate-500 px-1 text-white text-xs font-semibold rounded">
                                    Edit
                                </Link>
                                <div class="text-xs truncate">
                                    {{ item.from_time.substring(0, 5) }} - {{ item.to_time.substring(0, 5) }}
                                </div>
                                <span class="truncate bg-sky-900 text-white text-xs font-semibold mr-2 px-2.5 py-0.5 rounded bottom-0 top-auto">
                                    {{ item.type }}
                                </span>
                            </div>
                        </div>
                    </template>
                </template>
            </div>
            <div v-for="row in data.agendaItemRows" class="relative p-0 m-0 flex flex-wrap" style="height: 88px; border-top: solid 1px #cdd2d4;" :style="{'width': fullTimeWidth + 'px'}">
                <template v-for="item in row">
                    <template v-if="item.type != 'Plenair debat'">
                        <div
                            class="absolute h-full bg-blue-100 border-l border-r border-black"
                            :style="{'width': getWidth(item), 'left': getLeft(item)}"
                            style="padding-left: 6px; padding-right: 6px;"
                        >
                            <div class="m-2">
                                <h1 class="font-bold text-xs truncate">{{ item.title }}</h1>
                                <Link :href="'/agendaitem/edit/'+item.id" class="absolute right-0 top-0 m-2 bg-slate-500 px-1 text-white text-xs font-semibold rounded">
                                    Edit
                                </Link>
                                <div class="truncate text-xs">
                                    {{ item.from_time.substring(0, 5) }} - {{ item.to_time.substring(0, 5) }}
                                </div>
                                <span class="bg-sky-900 text-white text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                                    {{ item.type }}
                                </span>
                                <div v-if="item.commission" class="truncate text-xs">
                                    {{ item.commission }}
                                </div>
                            </div>
                        </div>
                    </template>
                </template>
            </div>
        </div>
        
        <div class="inline-flex rounded-md shadow-md w-full p-2">
            <Link href="/agendaitem/create" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                Agenda item aanmaken
            </Link>
        </div>
    </div>

</template>