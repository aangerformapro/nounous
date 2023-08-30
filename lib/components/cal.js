
import { Calendar } from '@fullcalendar/core';
import interactionPlugin from '@fullcalendar/interaction';
import dayGridPlugin from '@fullcalendar/daygrid';

import timeGridPlugin from '@fullcalendar/timegrid';



const calendarElement = document.getElementById('calendar');

if (calendarElement)
{

   const data = await fetch('/api/calendar').then(resp=>resp.json());


   console.debug(data);



    const calendar = new Calendar(calendarElement, {
        plugins: [
            interactionPlugin,
            dayGridPlugin,
            timeGridPlugin,
        ],

        initialView: 'timeGridWeek',
        editable: true,
        selectable: true,
        events: data,
        headerToolbar: {
            start: 'title',
            center: 'timeGridDay timeGridWeek dayGridMonth',
            end: 'today prev,next'
        },
        buttonText: {
            today: "aujourd'hui",
            month: 'mois',
            week: 'semaine',
            day: 'jour',
            year: "année",
            list: 'liste'
        }
    });
    calendar.setOption('locale', 'fr');
    calendar.render();
}




/**
 * Event Object - Docs | FullCalendar
 * @link https://fullcalendar.io/docs/event-object
 */


// events: [
//     {
//       title: 'BCH237',
//       start: '2019-08-12T10:30:00',
//       end: '2019-08-12T11:30:00',
//       extendedProps: {
//         department: 'BioChemistry'
//       },
//       description: 'Lecture'
//     }
//     // more events ...
//   ],