<x-filament-panels::page>

    <div id="description" class="hidden absolute bg-white rounded-lg shadow py-2 px-4 z-50"></div>
    <div id='calendar' class="z-10"></div>
    
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script src='fullcalendar/core/index.global.js'></script>
    <script src='fullcalendar/core/locales/hu.global.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const descriptionEl = document.getElementById('description');

            const navbar = document.getElementsByClassName('fi-topbar')[0];
            const header = document.getElementsByClassName('fi-header')[0];
            const height = screen.height - (navbar.offsetHeight + header.offsetHeight) - 280;

            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {

                // Display settings
                allDaySlot: false,
                dayHeaderFormat: { weekday: 'short' },
                locale: 'hu',
                eventDisplay: 'block',
                nowIndicator: true,
                height: height,
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'dayGridMonth,timeGridSevenDay,timeGridDay' // user can switch between these
                },
                slotLabelFormat: {
                    hour: 'numeric',
                    minute: '2-digit',
                },
                eventTimeFormat: {
                    hour: 'numeric',
                    minute: '2-digit',
                    meridiem: false
                },

                // Hover
                eventMouseEnter: function(info) {
                    // Display description when hovering over an event
                    descriptionEl.innerHTML = info.event.extendedProps.description;
                    descriptionEl.style.display = 'block';
                    descriptionEl.style.left = (info.jsEvent.pageX + 10) + 'px';
                    descriptionEl.style.top = (info.jsEvent.pageY + 10) + 'px';
                },
                eventMouseLeave: function () {
                    // Hide description when mouse leaves an event
                    descriptionEl.style.display = 'none';
                },

                // Time settings
                weekends: true,                 // Include Saturday/Sunday columns in any of the calendar views.        https://fullcalendar.io/docs/weekends
                firstDay: 1,                    // Sunday=0, Monday=1, Tuesday=2, etc.
                scrollTime:  '08:00:00',        // Determines how far forward the scroll pane is initially scrolled.    https://fullcalendar.io/docs/scrollTime
                slotMinTime: '08:00:00',        // Determines the first time slot that will be displayed for each day.  https://fullcalendar.io/docs/slotMinTime
                slotMaxTime: '22:00:00',        // Determines the last time slot that will be displayed for each day.   https://fullcalendar.io/docs/slotMaxTime
                
                // Views
                initialView: 'dayGridMonth',    // The initial view when the calendar loads.                            https://fullcalendar.io/docs/initialView
                views: {
                    // Custom view
                    timeGridSevenDay: {
                        type: 'timeGridWeek',
                        dayCount: 7,
                        buttonText: 'Heti',
                    },

                    // Overriding the default views
                    dayGridMonth: {
                        buttonText: 'Havi',
                    },
                    timeGridDay: {
                        buttonText: 'Napi',
                    }
                },

                events: {!! $events !!},

            });
            calendar.render();
            window.dispatchEvent(new Event('resize'));

            // set the url parameter
            const url = window.location.origin + window.location.pathname + '?view='
            let params = new URLSearchParams(window.location.search);

            const monthly = document.getElementsByClassName('fc-dayGridMonth-button')[0]
            const weekly  = document.getElementsByClassName('fc-timeGridSevenDay-button')[0]
            const daily   = document.getElementsByClassName('fc-timeGridDay-button')[0]

            monthly.addEventListener('click', function() {
                history.pushState(null, "", url + 'havi');
            });
            
            weekly.addEventListener('click', function() {
                history.pushState(null, "", url + 'heti');
            });
            
            daily.addEventListener('click', function() {
                history.pushState(null, "", url + 'napi');
            });
            
            switch (params.get('view')) {
                case 'heti':
                    calendar.changeView('timeGridWeek')
                    break;

                case 'napi':
                    calendar.changeView('timeGridDay')
                    break;
            
                default:
                    calendar.changeView('dayGridMonth')
                    break;
            }
        });
    </script>
</x-filament-panels::page>
