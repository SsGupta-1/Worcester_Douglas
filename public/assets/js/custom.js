$('.form-control').each(function(){
	if($(this).val()!=''){
		$(this).parent('.form-group').addClass("is-filled");
	}
});

var current = location.pathname;
$('.navbar-nav li a').each(function(){
	var $this = $(this);
	if($this.attr('href').indexOf(current) !== -1){
		$this.addClass('active');
	}
})

jQuery(function($) {

	//$('.dataTable').DataTable();
	var table = $('.dataTableSearch > table').DataTable();
	$('#search').keyup(function(){
		table.search($(this).val()).draw() ;
	})

	$('.otp-input input').keyup(function(){
		$(this).next().focus();
	}).keyup(function(e){
		if(e.keyCode == 8){
			$(this).prev().focus();
		}
	});

     var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
     $('.navbar-nav li a').each(function() {
      if (this.href === path) {
       $(this).addClass('active');
      }
     });
    });

$('.form-control').on("focus", function() {
	var val = $(this).val();
	$(this).parent('.form-group').addClass("is-focused");
	if(val==''){
		$(this).parent('.form-group').removeClass("is-filled");
	}else {
		$(this).parent('.form-group').addClass("is-filled");
	}
}).on("blur", function() {
	var val = $(this).val();
	$(this).parent(".form-group").removeClass("is-focused");
	if(val!=''){
		$(this).parent('.form-group').addClass("is-filled");
	}else {
		$(this).parent('.form-group').removeClass("is-filled");
	}
});

$('.showPassword').click(function(){
	$(this).toggleClass('inActive');
	if($(this).hasClass('inActive')){
		$(this).closest('.password-field').find('.form-control').attr('type','text');
	}else {
		$(this).closest('.password-field').find('.form-control').attr('type','password');
	}
});

$(document).on("focus",'.selectize-control', function() {
	if($(this).is('.search-opt,.searchOptNew')){
		var val = $(this).find('input').val();
		$(this).parent('.form-group').addClass("is-focused");
		if(val==''){
			$(this).parent('.form-group').removeClass("is-filled");
		}else {
			$(this).parent('.form-group').addClass("is-filled");
		}
	}
});
$(document).on("blur",'.selectize-control', function() {
	var val = $(this).find('.item').text();
	$(this).parent(".form-group").removeClass("is-focused");
	if(val!=''){
		$(this).parent('.form-group').addClass("is-filled");
	}else {
		$(this).parent('.form-group').removeClass("is-filled");
	}
});

/* $('.step-count li').click(function(){
	var index = $(this).index()+1;
	console.log('index',index)
	if(index==1){
		$('.action #back').hide();
		$('.action #continue').show();
		$('.action #save').hide();
	}
	if(index==2){
		$('.action #back').show();
		$('.action #continue').show();
		$('.action #save').hide();
	}
	if(index==3){
		$('.action #back').show();
		$('.action #continue').hide();
		$('.action #save').show();
	}
	if(!$(this).hasClass('active')){
		var elem_index = $(this).index();
		$('.step-count li').removeClass('active');
		$(this).addClass('active');
		var step_wrap_id = $(this).parent().attr('data-stepid');
		$('#step-id-'+step_wrap_id).find('.step.active').slideUp('fast').removeClass('active');
		$('#step-id-'+step_wrap_id).find('.step').eq(elem_index).slideDown('fast').addClass('active');
	}
}); */
$('header .search-icon').click(function(){
    $('.header-search').fadeIn('fast');
	$('.header-search input').focus();
    $('#mask').fadeIn('fast');
});
$('#mask').click(function(){
    $('.header-search').fadeOut('fast');
    $(this).fadeOut('fast')
});
var step_count = $('.form-inner').find('.step').length;
$('.action .btn').click(function(){
	var id = $(this).attr('id');
	if(id=="continue"){
		var active_index = $(this).closest('.form-inner').find('.step.active').index()+2;
		$(this).closest('.form-inner').find('.step.active').removeClass('active').slideUp().next().slideDown().addClass('active');
		console.log('active_index',active_index)
		if(active_index>0){
			$(this).prev().show();
		}
		if(active_index==step_count){
			$(this).hide();
			$(this).next().show();
		}		
	}
	if(id=="back"){
		var active_index = $(this).closest('.form-inner').find('.step.active').index()+2;
		$(this).closest('.form-inner').find('.step.active').removeClass('active').slideUp().prev().slideDown().addClass('active');
		$(this).next().show();
		$(this).next().next().hide();
		if(active_index==step_count){
			$(this).hide();
		}		
	}
	var index = $(this).closest('.form-inner').find('.step.active').index()+1;
	$('.step-count li').removeClass('active');
	$('.step-count li:nth-child('+index+')').addClass('active');
});


$('.over-label.upload-file input[type="file"]').change(function(e){
	var fileName = e.target.files[0].name;
	$(this).parent().find('.fileName').text(fileName);
});
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
	$('[data-toggle="popover"]').popover();
	$('#select-reason').on('change',function(){
		var reason = $(this).val();
		if(reason=="other"){
			console.log($(this).val())
			$(this).parents('.modal').find('#write-reason').show();
			$(this).parents('.modal').find('#write-reason .form-control').focus();
		}else {
			$(this).parents('.modal').find('#write-reason').hide();			
		}
	});
	$('.cancel-modal').click(function(){
		$('#editModal').find('.modal-title').text('Cancel Class');
	});
	$('.edit-class[data-toggle="modal"]').click(function(){
		$('#editModal').find('.modal-title').text('Reschedule Class');
	});
	
$('.search-opt').selectize({
	sortField: 'text'
});
	
});

$(function () {
	$('.date').datetimepicker({
		format: 'DD MM YYYY'
	});
	$('.time').datetimepicker({
		format: 'LT'
	});
	$('.selectize-control').each(function(){
		var val = $(this).find('.item').text();
		if(val!=''){
			$(this).parent('.form-group').addClass("is-filled");
		}
	});
});

$(function() {
	$(".slider-range").each(function(){
		var val = $(this).parent('li').find('.rating').val();
		$(this).slider({
			range: "max",
			min: 1,
			max: 10,
			value: val,
			slide: function( event, ui ) {
				$(this).parent('li').find('.rating').val(ui.value);
				$(this).parent('li').find('.ui-slider-handle').text(ui.value);
			},
			create: function() {
				var val = $(this).parent('li').find('.rating').val();
				$(this).parent('li').find('.ui-slider-handle').text(val);
			}
		});
	});
});


var ctx = document.getElementById("hotelsChart").getContext('2d');
var myChart_bg_color = ctx.createLinearGradient(0, 0, 0, 275);
myChart_bg_color.addColorStop(0, '#86a544');
myChart_bg_color.addColorStop(1, 'rgba(134,165,68,0)');
var myChart = new Chart(ctx, {
  type: 'line',
	data: {
    labels: mothName,
    datasets: [{
      label: 'Views',
      data: dataCount,
      backgroundColor: myChart_bg_color,
      borderWidth: 3,
      borderColor: '#86a544',
      pointBorderWidth: 0,
      pointBorderColor: '#86a544',
      pointRadius: 3,
      pointBackgroundColor: '#fff',
      pointHoverBackgroundColor: '#86a544',
      pointHoverBorderColor: '#86a544',
    }]
  },
  options: {
    legend: {
      display: false
    },
		tooltips: {
			titleFontSize: 16,
			titleFontColor: '#ffffff',
			bodyFontColor: '#ffffff',
			backgroundColor: '#86a544',
			displayColors: false,
			callbacks: {
      	title: function(tooltipItems, data) {
          return '';
        },
				label: function(tooltipItem, data) {
          var item = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
          return item + '';
        }
			}
		},
    scales: {
      yAxes: [{
        gridLines: {
          // display: false,
          drawBorder: true,
          color: '#fff',
        },
        ticks: {
          beginAtZero: true,
          stepSize: 600,
          /* mirror: true,
          padding: 0, */
          callback: function(value, index, values) {
            return value+'k';
          }
        },
		display: true,
		gridLines: {
			display: true,
			borderDash: [8, 4],
			tickMarkLength: 10,
			color: "#565656"
		},
		ticks: {
		  fontColor: "#fff",
		  fontSize: 10,
		}
      }],
      xAxes: [{
        gridLines: {
			display: true,
			borderDash: [8, 4],
			tickMarkLength: 10,
			color: "#565656"
        },
		ticks: {
		  fontColor: "#fff",
		  fontSize: 12,
		}
      }]
    },
  }
});


var ctx = document.getElementById("revenueChart").getContext('2d');
var myChart_bg_color = ctx.createLinearGradient(0, 0, 0, 275);
myChart_bg_color.addColorStop(0, '#86a544');
myChart_bg_color.addColorStop(1, 'rgba(134,165,68,0)');
var myChart = new Chart(ctx, {
  type: 'line',
	data: {
    // labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
	labels: mothName,
    datasets: [{
      label: 'Views',
	  lineTension: 0,
    //   data: [2000, 1500, 1000, 1000, 500, 1000, 1560, 1054,2000, 1000, 3000, 1000, 1500, 2000, 1060, 1054,],
	  data: monthlyRevenue,
      backgroundColor: myChart_bg_color,
      borderWidth: 3,
      borderColor: '#86a544',
      pointBorderWidth: 0,
      pointBorderColor: '#86a544',
      pointRadius: 3,
      pointBackgroundColor: '#fff',
      pointHoverBackgroundColor: '#86a544',
      pointHoverBorderColor: '#86a544',
    }]
  },
  options: {
    legend: {
      display: false
    },
		tooltips: {
			titleFontSize: 16,
			titleFontColor: '#ffffff',
			bodyFontColor: '#ffffff',
			backgroundColor: '#86a544',
			displayColors: false,
			callbacks: {
      	title: function(tooltipItems, data) {
          return '';
        },
				label: function(tooltipItem, data) {
          var item = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
          return item + '';
        }
			}
		},
    scales: {
      yAxes: [{
        gridLines: {
          // display: false,
          drawBorder: true,
          color: '#fff',
        },
        ticks: {
          beginAtZero: true,
          stepSize: 600,
          /* mirror: true,
          padding: 0, */
          callback: function(value, index, values) {
            return value+'k';
          }
        },
		display: true,
		gridLines: {
			display: true,
			borderDash: [8, 4],
			tickMarkLength: 10,
			color: "#565656"
		},
		ticks: {
		  fontColor: "#fff",
		  fontSize: 10,
		}
      }],
      xAxes: [{
        gridLines: {
			display: true,
			borderDash: [8, 4],
			tickMarkLength: 10,
			color: "#565656"
        },
		ticks: {
		  fontColor: "#fff",
		  fontSize: 12,
		}
      }]
    }
  }
});