/**
*
* Filter Search - V1.0 (26/06/2014-01:05)
* Filter Search - V1.1 (02/07/2014-17:38)
*
**/

$(document).ready(function(){
	var checkall= $("#checkall");
	var month  	= $("#monthFilter");
	var year   	= $("#yearFilter");
	var search 	= $("#searchFilter");
	var link   	= search.attr('href');

	checkall.on("click",function(e){
		$(".bulk").click().change();
	})
	month.on("change",function(e){
		search.attr('data-month',month.val());
	})
	year.on("change",function(e){
		search.attr('data-year',year.val());
	})
	search.on("click",function(e){
		e.preventDefault();
		monthActive=search.attr('data-month');
		yearActive=search.attr('data-year');

		if(monthActive != '' && yearActive != ''){
			if(!isNaN(monthActive) && !isNaN(yearActive)){
				link+="month/"+monthActive+"/year/"+yearActive;
				location.href=link;
			}else alert('Oops! Enter valid data!');
		}else alert('Oops! Enter a month and year before listing!');
	})
})