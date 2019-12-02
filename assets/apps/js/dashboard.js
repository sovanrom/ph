$(function() {
	$('#notice_calendar').fullCalendar({
		header: {
			left: 'title',
			right: 'today prev,next'
		},
		editable: false,
		firstDay: 1,
		height: 480,
		droppable: false,
		selectable: true,
		selectHelper: true
	});
});