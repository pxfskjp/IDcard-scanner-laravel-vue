setTimeout(function(){
	
	
	window.location.reload();//with the true parameter it reloads from the server as opposed from the cache
	
 }, 120000);
/*
//	Call to reset storage so things don't get fucky
pageStorage();

jQuery(document).ready(function($) {
	//	Change text in file upload box to file name
	$('input[type="file"]').change(function(e){
		$(this).parent().find($('span')).text(e.target.files[0].name);
	});
});

// Pagination code to work with AJAX calls
$(function() {	
	$('body').on('click', '.pagination a', function(e) {
		e.preventDefault();
		var url = $(this).attr('href');
		var page = $(this).text();
		getData(url);
		localStorage.setItem('page',parseInt(page));
		localStorage.setItem('target',window.location.href);
	});
});

// Search bar working with paginate
$(function() {
	$('.search').click(function() {
		$('#form_search_text').focus();
	});

	$('#form_search_text').keypress(function(e) {
		if(e.which == 13)
			$('#submit_search').click();
	});

	$('#submit_search').click(function(e) {
		e.preventDefault();
		var terms = $('#form_search_text').val();
		var base_url = (window.location.href).split('?');
		var url = (base_url[0]+'/search?term='+terms).replace('/index', '');
		localStorage.setItem('search', url);
		// If search is null/empty, clean up
		if(terms == '' || terms == ' ') {
			localStorage.removeItem('search');
			return window.location.href = window.location.pathname;
		}
		getData(url);
		window.history.pushState("", "", base_url[0]+'?term='+terms);
	});
});

function getData(url) {
	$('.data-container').css('opacity', 0);
	$('.data-container').removeClass('hidden');
	$.ajax({
		url : url
	}).done(function (data) {
		$('.data-container').html(data).animate({'opacity': 1}, 350); 
	}).fail(function () {
		console.log('Page could not be loaded.');
	});
}

function pageStorage() {
	if(localStorage.getItem('target') != window.location.href && 
		(window.location.href).includes('edit') == false && 
		(window.location.href).includes('view') == false)
		localStorage.setItem('page',null);
}

// Highlight active page in NAV
// If a navbar list item is clicked, store the option in storage
$('.navbar-nav li').click(function() {
	var nav = $(this).data('nav');
	localStorage.clear();
	localStorage.setItem('nav', nav);
});
// If the title is clicked, set nav to null in storage
$('.navbar-brand').click(function() {
	localStorage.setItem('nav', null);
});
// On page load, add the active class to the current pages nav
$(document).ready(function(){
	var nav = (window.location.pathname).split('/')[1];
	$('.navbar-nav li[data-nav='+nav+']').addClass('active');
});

// Respecting the back button
var current_url = ((window.location.pathname).split('/')[1]).split('?')[0];
if(localStorage.getItem('current_page') != current_url) {
	localStorage.removeItem('current_page');
	localStorage.setItem('search',null);
}

function storePage(current_page, val) {
	localStorage.setItem('current_page', current_page);
	localStorage.setItem('val', val);
}

function storePagination(page_num) {
	localStorage.setItem('page', page_num);
}

function storeSearch(search) {
	localStorage.setItem('search', search);
}
*/