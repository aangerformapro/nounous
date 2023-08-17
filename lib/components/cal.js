
import { Calendar } from '@fullcalendar/core';
import interactionPlugin from '@fullcalendar/interaction';
import dayGridPlugin from '@fullcalendar/daygrid';


const calendar = new Calendar(document.getElementById('calendar'), {
    plugins: [

        interactionPlugin,
        dayGridPlugin
    ],

    initialView: 'dayGridWeek',
    editable: true,
    selectable: true,
    events: [
        { title: 'Meeting', start: new Date() }
    ],
    headerToolbar: {
        start: 'title',
        center: 'dayGridWeek dayGridMonth dayGridYear',
        end: 'today prev,next'
    },
    buttonText: {
        today: "aujourd'hui",
        month: 'mois',
        week: 'semaine',
        day: 'jour',
        list: 'liste'
    }
});
calendar.setOption('locale', 'fr');
calendar.render();

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