gvChartInit();

$(window).load(function()
{
	$("#logo img").vAlign();
});

var maxBox2Height = 0;

$(document).ready(function()
{
	$(".tabs").tabs();
	$(".accordion").accordion();
	$(".accordion").before("<div class='space1'></div>");

	$("#menuUl").superfish(
	{ 
		animation: {height: 'show'},
		speed: 1
	});

	$(".box > div").wrap("<div class='boxBg' />");
	$(".box .boxBg").wrap("<div class='boxSlide' />");
	$(".box .boxSlide").append("<div class='boxFooter'><img src='img/ws_box_footer.png' /></div>");
	$(".box .boxBg > div").wrap("<div class='boxContent' />");

	$(".box2 > div").wrap("<div class='box2Bg' />");
	$(".box2 .box2Bg").wrap("<div class='box2Slide' />");
	$(".box2 .box2Slide").append("<div class='box2Footer'><img src='img/ws_box_2column_footer.png' /></div>");
	$(".box2 .box2Bg > div").wrap("<div class='box2Content' />");

	$(".box2:even").after("<div class='vSpace20'>&nbsp;</div>");
	$(".box2:odd").after("<div class='clear'></div><div class='space10'></div>");
	$(".text2:even").after("<div class='vSpace20'>&nbsp;</div>");
	$(".text2:odd").after("<div class='clear'></div>");

	$(".box > h2.closed").each(function()
	{
		$(this).parent().children(".boxSlide").hide();
	});

	$(".box > h2").bind("click", function()
	{
		if($(this).hasClass("closed"))
		{
			$(this).addClass("opened");
			$(this).removeClass("closed");
		}
		else
		{
			$(this).addClass("closed");
			$(this).removeClass("opened");
		}

		$(this).parent().children(".boxSlide").toggle();
	});

	$(".box2 > h2.closed").each(function()
	{
		$(this).parent().children(".box2Slide").hide();
	});

	$(".box2 > h2").bind("click", function()
	{
		if($(this).hasClass("closed"))
		{
			$(this).addClass("opened");
			$(this).removeClass("closed");
		}
		else
		{
			$(this).addClass("closed");
			$(this).removeClass("opened");
		}

		$(this).parent().children(".box2Slide").toggle();
	});

	$(".box > h2").disableSelection();
	$(".box2 > h2").disableSelection();

	$(".box table.areaChart").each(function()
	{
		$(this).gvChart(
		{
			chartType: "AreaChart",
			gvSettings:
			{
				width: 920,
				height: 300
			}
		});
	});
	
	$(".box table.lineChart").each(function()
	{
		$(this).gvChart(
		{
			chartType: "LineChart",
			gvSettings:
			{
				width: 920,
				height: 300
			}
		});
	});
	
	$(".box table.barChart").each(function()
	{
		$(this).gvChart(
		{
			chartType: "BarChart",
			gvSettings:
			{
				width: 920,
				height: 300
			}
		});
	});
	
	$(".box table.columnChart").each(function()
	{
		$(this).gvChart(
		{
			chartType: "ColumnChart",
			gvSettings:
			{
				width: 920,
				height: 300
			}
		});
	});
	
	$(".box table.pieChart").each(function()
	{
		$(this).gvChart(
		{
			chartType: "PieChart",
			gvSettings:
			{
				width: 920,
				height: 300
			}
		});
	});
	
	$(".box2 table.areaChart").each(function()
	{
		$(this).gvChart(
		{
			chartType: "AreaChart",
			gvSettings:
			{
				width: 430,
				height: 200
			}
		});

		$(this).parent().css("height", 200);
	});
	
	$(".box2 table.lineChart").each(function()
	{
		$(this).gvChart(
		{
			chartType: "LineChart",
			gvSettings:
			{
				width: 430,
				height: 200
			}
		});

		$(this).parent().css("height", 200);
	});
	
	$(".box2 table.barChart").each(function()
	{
		$(this).gvChart(
		{
			chartType: "BarChart",
			gvSettings:
			{
				width: 430,
				height: 200
			}
		});

		$(this).parent().css("height", 200);
	});
	
	$(".box2 table.columnChart").each(function()
	{
		$(this).gvChart(
		{
			chartType: "ColumnChart",
			gvSettings:
			{
				width: 430,
				height: 200
			}
		});

		$(this).parent().css("height", 200);
	});
	
	$(".box2 table.pieChart").each(function()
	{
		$(this).gvChart(
		{
			chartType: "PieChart",
			gvSettings:
			{
				width: 430,
				height: 200
			}
		});

		$(this).parent().css("height", 200);
	});
	
	$(".box2 .box2Content div").each(function()
	{
		if($(this).height() > maxBox2Height)
		{
			maxBox2Height = $(this).height();
		}
	});

	if(maxBox2Height != 0)
	{
		//$(".box2 .box2Content div").height(maxBox2Height);
	}

	$("tbody tr:odd").addClass("highlight");

	$(".dataGrid thead th input:checkbox").click(function()
	{
		var deleteAllChecked = this.checked;
		
		$(".dataGrid tbody tr input:checkbox").each(function()
		{
			this.checked = deleteAllChecked;
		});
	});

	$(".textField > div").addClass("textFieldName");
	$(".textField input").wrap("<div class='textFieldBg' />");
	
	$(".textField2 > div").addClass("textField2Name");
	$(".textField2 input").wrap("<div class='textField2Bg' />");
	
	$(".textField2:even").addClass("textField2Padding");
	$(".textField2:odd").after("<div class='clear'></div>");
	
	$(".textField3 > div").addClass("textField3Name");
	$(".textField3 input").wrap("<div class='textField3Bg' />");

	var textField3Counter = 1;
	
	$(".textField3").each(function()
	{
		if(textField3Counter % 3 == 0)
		{
			$(this).after("<div class='clear'></div>");
		}
		else
		{
			$(this).addClass("textField3Padding");
		}

		textField3Counter++;
	});
	
	var text3Counter = 1;
	
	$(".text3").each(function()
	{
		if(text3Counter % 3 == 0)
		{
			$(this).after("<div class='clear'></div>");
		}
		else
		{
			$(this).addClass("textField3Padding");
		}

		text3Counter++;
	});
	
	$(".textField4 > div").addClass("textField4Name");
	$(".textField4 input").wrap("<div class='textField4Bg' />");
	
	var textField4Counter = 1;
	
	$(".textField4").each(function()
	{
		if(textField4Counter % 4 == 0)
		{
			$(this).after("<div class='clear'></div>");
		}
		else
		{
			$(this).addClass("textField4Padding");
		}

		textField4Counter++;
	});
	
	var text4Counter = 1;
	
	$(".text4").each(function()
	{
		if(text4Counter % 4 == 0)
		{
			$(this).after("<div class='clear'></div>");
		}
		else
		{
			$(this).addClass("textField4Padding");
		}

		text4Counter++;
	});

	$(".textArea > div").addClass("textAreaName");
	$(".textArea textarea").wrap("<div class='textAreaBg' />");
	
	$(".selectField > div").addClass("selectFieldName");
	
	$(".fileUpload > div").addClass("fileUploadName");

	$(".button:last").after("<div class='clear'></div>");
	$(".button").wrap("<div class='buttonWrap' />");
	$(".buttonWrap").prepend("<div class='buttonLeft'><img src='img/ws_button_left.jpg' /></div>");
	$(".buttonWrap").append("<div class='buttonRight'><img src='img/ws_button_right.jpg' /></div>");
	$(".buttonRight").after("<div class='clear'></div>");

	$(".datepicker").datepicker();
	$(".richTextArea textarea").wysiwyg();

	$('#calendar').fullCalendar({
		// US Holidays
		events: 'http://www.google.com/calendar/feeds/usa__en%40holiday.calendar.google.com/public/basic'
	});
});