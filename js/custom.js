function getData() {
	$('#allcontent').hide();
	
	$table = document.getElementById("betting-data-table");
	$.ajax({
		type : "GET",
		contentType : "application/json",
		url : "server.php",
		data : null,
		dataType : 'json',
		cache : false,
		timeout : 600000,
		success : function(data) {			
			appendDataToTable(data);
		},
		error : function(e) {
		},
		complete : function() {
			$('#loading').css('visibility', 'hidden');
		}
	});
}

function appendDataToTable(data) {
	console.log('appendDataToTable');
	var htmlString = '<tbody>';
	
	for ( var item in data['data']) {		
		htmlString += makeRecord(item, data);
	}
	htmlString += '</tbody>'
	$('#betting-data-table').append(htmlString);
	$('#loading').hide();
}

function makeRecord(item, data) {
	var htmlString = '';
	var isScore = data['data'][item].score != undefined ? '<td>'
			+ data['data'][item].score + '</td>'
			: '<td>0-0</td>';
	htmlString += '<tr rowspan="2"><td colspan="2">'
			+ data['data'][item].startTime + '</td>'
			+ isScore;
	var status = '';
	if (data['data'][item].status == true) {
		status = ' status';
	}

	var scoreAndTimeData = '';
	if (data['data'][item].status == true) {
		var time = data['data'][item].timeElapsed;
		var matchstatus = data['data'][item].matchstatus;
		scoreAndTimeData = '<br><i class="fa fa-play-circle" style="font-size:15px"></i><button style="bottom:0;background: #ef5151;">'
				+ matchstatus
				+ '</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <i class="fa fa-clock-o" style="font-size:15px"></i><button style="bottom:0;background:#3caf3b;"> '
				+ time + ' </button>';
	}
	htmlString += '<td class="match-name'
			+ status
			+ '"><a href="https://www.betfair.com/exchange/plus/football/market/'
			+ data['data'][item]['MATCH_ODDS'].marketId
			+ '" target="_blank">'
			+ data['data'][item].matchName + '</a>'
			+ scoreAndTimeData + '</td>';
	if ($('#filter').val() == 0 || $('#filter').val() == 1){
		if (data['data'][item]['MATCH_ODDS'] != null
			&& data['data'][item]['MATCH_ODDS'] != '') {
			var link = 'https://www.betfair.com/exchange/plus/football/market/'
					+ data['data'][item]['MATCH_ODDS'].marketId;
			var matchOddsMatchedMoney = data['data'][item]['MATCH_ODDS']['matchedMoney'] != undefined ? data['data'][item]['MATCH_ODDS']['matchedMoney']
					: "";
			var backPrice1 = data['data'][item]['MATCH_ODDS']['1'] != undefined ? data['data'][item]['MATCH_ODDS']['1'].backPrice
					: "";
			var backSize1 = data['data'][item]['MATCH_ODDS']['1'] != undefined ? data['data'][item]['MATCH_ODDS']['1'].backSize
					: "";
			var layPrice1 = data['data'][item]['MATCH_ODDS']['1'] != undefined ? data['data'][item]['MATCH_ODDS']['1'].layPrice
					: "";
			var laySize1 = data['data'][item]['MATCH_ODDS']['1'] != undefined ? data['data'][item]['MATCH_ODDS']['1'].laySize
					: "";

			var backPricex = data['data'][item]['MATCH_ODDS']['x'] != undefined ? data['data'][item]['MATCH_ODDS']['x'].backPrice
					: "";
			var backSizex = data['data'][item]['MATCH_ODDS']['x'] != undefined ? data['data'][item]['MATCH_ODDS']['x'].backSize
					: "";
			var layPricex = data['data'][item]['MATCH_ODDS']['x'] != undefined ? data['data'][item]['MATCH_ODDS']['x'].layPrice
					: "";
			var laySizex = data['data'][item]['MATCH_ODDS']['x'] != undefined ? data['data'][item]['MATCH_ODDS']['x'].laySize
					: "";

			var backPrice2 = data['data'][item]['MATCH_ODDS']['2'] != undefined ? data['data'][item]['MATCH_ODDS']['2'].backPrice
					: "";
			var backSize2 = data['data'][item]['MATCH_ODDS']['2'] != undefined ? data['data'][item]['MATCH_ODDS']['2'].backSize
					: "";
			var layPrice2 = data['data'][item]['MATCH_ODDS']['2'] != undefined ? data['data'][item]['MATCH_ODDS']['2'].layPrice
					: "";
			var laySize2 = data['data'][item]['MATCH_ODDS']['2'] != undefined ? data['data'][item]['MATCH_ODDS']['2'].laySize
					: "";

			htmlString += '<td><a href="' + link
					+ '" target="_blank">'
					+ matchOddsMatchedMoney
					+ '</a></td><td><a href="' + link
					+ '" target="_blank"><p class="back">'
					+ backPrice1 + '</p><p>' + backSize1
					+ '</p></a></td><td><a href="' + link
					+ '" target="_blank"><p class="lay">'
					+ layPrice1 + '</p><p>' + laySize1
					+ '</p></a></td><td><a href="' + link
					+ '" target="_blank"><p class="back">'
					+ backPricex + '</p><p>' + backSizex
					+ '</p></a></td><td><a href="' + link
					+ '" target="_blank"><p class="lay">'
					+ layPricex + '</p><p>' + laySizex
					+ '</p></a></td><td><a href="' + link
					+ '" target="_blank"><p class="back">'
					+ backPrice2 + '</p><p>' + backSize2
					+ '</p></a></td><td><a href="' + link
					+ '" target="_blank"><p class="lay">'
					+ layPrice2 + '</p><p>' + laySize2
					+ '</p></a></td>';
		} else {
			htmlString += '<td></td><td><p class="back"></p><p></p></td><td><p class="lay"></p><p></p></td><td><p class="back"></p><p></p></td><td><p class="lay"></p><p></p></td>';
		}
	}
	if ($('#filter').val() == 0 || $('#filter').val() == 2)
	if (data['data'][item]['OVER_UNDER_15'] != null
			&& data['data'][item]['OVER_UNDER_15'] != ''
			&& !isEmpty(data['data'][item]['OVER_UNDER_15'])) {
		var link = 'https://www.betfair.com/exchange/plus/football/market/'
				+ data['data'][item]['OVER_UNDER_15'].marketId;
		var under15MatchedMoney = data['data'][item]['OVER_UNDER_15']['matchedMoney'] != undefined ? data['data'][item]['OVER_UNDER_15']['matchedMoney']
				: "";
		var menoBackPrice = data['data'][item]['OVER_UNDER_15']['meno'] != undefined ? data['data'][item]['OVER_UNDER_15']['meno'].backPrice
				: "";
		var menoBackSize = data['data'][item]['OVER_UNDER_15']['meno'] != undefined ? data['data'][item]['OVER_UNDER_15']['meno'].backSize
				: "";
		var menoLayPrice = data['data'][item]['OVER_UNDER_15']['meno'] != undefined ? data['data'][item]['OVER_UNDER_15']['meno'].layPrice
				: "";
		var menoLaySize = data['data'][item]['OVER_UNDER_15']['meno'] != undefined ? data['data'][item]['OVER_UNDER_15']['meno'].laySize
				: "";
		var piuBackPrice = data['data'][item]['OVER_UNDER_15']['piu'] != undefined ? data['data'][item]['OVER_UNDER_15']['piu'].backPrice
				: "";
		var piuBackSize = data['data'][item]['OVER_UNDER_15']['piu'] != undefined ? data['data'][item]['OVER_UNDER_15']['piu'].backSize
				: "";
		var piuLayPrice = data['data'][item]['OVER_UNDER_15']['piu'] != undefined ? data['data'][item]['OVER_UNDER_15']['piu'].layPrice
				: "";
		var piuLaySize = data['data'][item]['OVER_UNDER_15']['piu'] != undefined ? data['data'][item]['OVER_UNDER_15']['piu'].laySize
				: "";

		htmlString += '<td><a href="' + link
				+ '" target="_blank">'
				+ under15MatchedMoney
				+ '</a></td><td><a href="' + link
				+ '" target="_blank"><p class="back">'
				+ menoBackPrice + '</p><p>' + menoBackSize
				+ '</p></a></td><td><a href="' + link
				+ '" target="_blank"><p class="lay">'
				+ menoLayPrice + '</p><p>' + menoLaySize
				+ '</p></a></td><td><a href="' + link
				+ '" target="_blank"><p class="back">'
				+ piuBackPrice + '</p><p>' + piuBackSize
				+ '</p></a></td><td><a href="' + link
				+ '" target="_blank"><p class="lay">'
				+ piuLayPrice + '</p><p>' + piuLaySize
				+ '</p></a></td>';

	} else {
		htmlString += '<td></td><td><p class="back"></p><p></p></td><td><p class="lay"></p><p></p></td><td><p class="back"></p><p></p></td><td><p class="lay"></p><p></p></td>';
	}
	if ($('#filter').val() == 0 || $('#filter').val() == 3)
	if (data['data'][item]['OVER_UNDER_25'] != null
			&& data['data'][item]['OVER_UNDER_25'] != '') {
		var link = 'https://www.betfair.com/exchange/plus/football/market/'
				+ data['data'][item]['OVER_UNDER_25'].marketId;
		var under25MatchedMoney = data['data'][item]['OVER_UNDER_25']['matchedMoney'] != undefined ? data['data'][item]['OVER_UNDER_25']['matchedMoney']
				: "";
		var menoBackPrice = data['data'][item]['OVER_UNDER_25']['meno'] != undefined ? data['data'][item]['OVER_UNDER_25']['meno'].backPrice
				: "";
		var menoBackSize = data['data'][item]['OVER_UNDER_25']['meno'] != undefined ? data['data'][item]['OVER_UNDER_25']['meno'].backSize
				: "";
		var menoLayPrice = data['data'][item]['OVER_UNDER_25']['meno'] != undefined ? data['data'][item]['OVER_UNDER_25']['meno'].layPrice
				: "";
		var menoLaySize = data['data'][item]['OVER_UNDER_25']['meno'] != undefined ? data['data'][item]['OVER_UNDER_25']['meno'].laySize
				: "";
		var piuBackPrice = data['data'][item]['OVER_UNDER_25']['piu'] != undefined ? data['data'][item]['OVER_UNDER_25']['piu'].backPrice
				: "";
		var piuBackSize = data['data'][item]['OVER_UNDER_25']['piu'] != undefined ? data['data'][item]['OVER_UNDER_25']['piu'].backSize
				: "";
		var piuLayPrice = data['data'][item]['OVER_UNDER_25']['piu'] != undefined ? data['data'][item]['OVER_UNDER_25']['piu'].layPrice
				: "";
		var piuLaySize = data['data'][item]['OVER_UNDER_25']['piu'] != undefined ? data['data'][item]['OVER_UNDER_25']['piu'].laySize
				: "";

		htmlString += '<td><a href="' + link
				+ '" target="_blank">'
				+ under25MatchedMoney
				+ '</a></td><td><a href="' + link
				+ '" target="_blank"><p class="back">'
				+ menoBackPrice + '</p><p>' + menoBackSize
				+ '</p></a></td><td><a href="' + link
				+ '" target="_blank"><p class="lay">'
				+ menoLayPrice + '</p><p>' + menoLaySize
				+ '</p></a></td><td><a href="' + link
				+ '" target="_blank"><p class="back">'
				+ piuBackPrice + '</p><p>' + piuBackSize
				+ '</p></a></td><td><a href="' + link
				+ '" target="_blank"><p class="lay">'
				+ piuLayPrice + '</p><p>' + piuLaySize
				+ '</p></a></td>';
	} else {
		htmlString += '<td></td><td><p class="back"></p><p></p></td><td><p class="lay"></p><p></p></td><td><p class="back"></p><p></p></td><td><p class="lay"></p><p></p></td>';
	}
	if ($('#filter').val() == 0 || $('#filter').val() == 4)
	if (data['data'][item]['OVER_UNDER_35'] != null
			&& data['data'][item]['OVER_UNDER_35'] != '') {
		var link = 'https://www.betfair.com/exchange/plus/football/market/'
				+ data['data'][item]['OVER_UNDER_35'].marketId;
		var under35MatchedMoney = data['data'][item]['OVER_UNDER_35']['matchedMoney'] != undefined ? data['data'][item]['OVER_UNDER_35']['matchedMoney']
				: "";
		var menoBackPrice = data['data'][item]['OVER_UNDER_35']['meno'] != undefined ? data['data'][item]['OVER_UNDER_35']['meno'].backPrice
				: "";
		var menoBackSize = data['data'][item]['OVER_UNDER_35']['meno'] != undefined ? data['data'][item]['OVER_UNDER_35']['meno'].backSize
				: "";
		var menoLayPrice = data['data'][item]['OVER_UNDER_35']['meno'] != undefined ? data['data'][item]['OVER_UNDER_35']['meno'].layPrice
				: "";
		var menoLaySize = data['data'][item]['OVER_UNDER_35']['meno'] != undefined ? data['data'][item]['OVER_UNDER_35']['meno'].laySize
				: "";
		var piuBackPrice = data['data'][item]['OVER_UNDER_35']['piu'] != undefined ? data['data'][item]['OVER_UNDER_35']['piu'].backPrice
				: "";
		var piuBackSize = data['data'][item]['OVER_UNDER_35']['piu'] != undefined ? data['data'][item]['OVER_UNDER_35']['piu'].backSize
				: "";
		var piuLayPrice = data['data'][item]['OVER_UNDER_35']['piu'] != undefined ? data['data'][item]['OVER_UNDER_35']['piu'].layPrice
				: "";
		var piuLaySize = data['data'][item]['OVER_UNDER_35']['piu'] != undefined ? data['data'][item]['OVER_UNDER_35']['piu'].laySize
				: "";

		htmlString += '<td><a href="' + link
				+ '" target="_blank">'
				+ under35MatchedMoney
				+ '</a></td><td><a href="' + link
				+ '" target="_blank"><p class="back">'
				+ menoBackPrice + '</p><p>' + menoBackSize
				+ '</p></a></td><td><a href="' + link
				+ '" target="_blank"><p class="lay">'
				+ menoLayPrice + '</p><p>' + menoLaySize
				+ '</p></a></td><td><a href="' + link
				+ '" target="_blank"><p class="back">'
				+ piuBackPrice + '</p><p>' + piuBackSize
				+ '</p></a></td><td><a href="' + link
				+ '" target="_blank"><p class="lay">'
				+ piuLayPrice + '</p><p>' + piuLaySize
				+ '</p></a></td>';
	} else {
		htmlString += '<td></td><td><p class="back"></p><p></p></td><td><p class="lay"></p><p></p></td><td><p class="back"></p><p></p></td><td><p class="lay"></p><p></p></td>';
	}
	if ($('#filter').val() == 0 || $('#filter').val() == 5)
	if (data['data'][item]['OVER_UNDER_45'] != null
			&& data['data'][item]['OVER_UNDER_45'] != '') {
		var link = 'https://www.betfair.com/exchange/plus/football/market/'
				+ data['data'][item]['OVER_UNDER_45'].marketId;
		var under45MatchedMoney = data['data'][item]['OVER_UNDER_45']['matchedMoney'] != undefined ? data['data'][item]['OVER_UNDER_45']['matchedMoney']
				: "";
		var menoBackPrice = data['data'][item]['OVER_UNDER_45']['meno'] != undefined ? data['data'][item]['OVER_UNDER_45']['meno'].backPrice
				: "";
		var menoBackSize = data['data'][item]['OVER_UNDER_45']['meno'] != undefined ? data['data'][item]['OVER_UNDER_45']['meno'].backSize
				: "";
		var menoLayPrice = data['data'][item]['OVER_UNDER_45']['meno'] != undefined ? data['data'][item]['OVER_UNDER_45']['meno'].layPrice
				: "";
		var menoLaySize = data['data'][item]['OVER_UNDER_45']['meno'] != undefined ? data['data'][item]['OVER_UNDER_45']['meno'].laySize
				: "";
		var piuBackPrice = data['data'][item]['OVER_UNDER_45']['piu'] != undefined ? data['data'][item]['OVER_UNDER_45']['piu'].backPrice
				: "";
		var piuBackSize = data['data'][item]['OVER_UNDER_45']['piu'] != undefined ? data['data'][item]['OVER_UNDER_45']['piu'].backSize
				: "";
		var piuLayPrice = data['data'][item]['OVER_UNDER_45']['piu'] != undefined ? data['data'][item]['OVER_UNDER_45']['piu'].layPrice
				: "";
		var piuLaySize = data['data'][item]['OVER_UNDER_45']['piu'] != undefined ? data['data'][item]['OVER_UNDER_45']['piu'].laySize
				: "";

		htmlString += '<td><a href="' + link
				+ '" target="_blank">'
				+ under45MatchedMoney
				+ '</td><td><a href="' + link
				+ '" target="_blank"><p class="back">'
				+ menoBackPrice + '</p><p>' + menoBackSize
				+ '</p></a></td><td><a href="' + link
				+ '" target="_blank"><p class="lay">'
				+ menoLayPrice + '</p><p>' + menoLaySize
				+ '</p></a></td><td><a href="' + link
				+ '" target="_blank"><p class="back">'
				+ piuBackPrice + '</p><p>' + piuBackSize
				+ '</p></a></td><td><a href="' + link
				+ '" target="_blank"><p class="lay">'
				+ piuLayPrice + '</p><p>' + piuLaySize
				+ '</p></a></td>';
	} else {
		htmlString += '<td></td><td><p class="back"></p><p></p></td><td><p class="lay"></p><p></p></td><td><p class="back"></p><p></p></td><td><p class="lay"></p><p></p></td>';
	}
	htmlString += '</tr>';			
	return htmlString;
}

function isEmpty(obj) {
	for ( var key in obj) {
		if (obj.hasOwnProperty(key))
			return false;
	}
	return true;
}

function getData1() {

	$.ajax({
				type : "GET",
				contentType : "application/json",
				url : "server.php",
				data : null,
				dataType : 'json',
				cache : false,
				timeout : 600000,
				success : function(data) {			
					console.log(data);
							
					var originalCount = $('#betting-data-table tbody tr').length;
					// console.log('---------------------');
					// console.log('original', originalCount);
					// console.log('updated', data['data'].length);
					if(data['data'].length == 0) return;
					var addedCnt = 0;							
					for ( var item in data['data']) {			

						var htmlString = makeRecord(item, data);									
						if(item < originalCount) {
							$('#betting-data-table tbody tr').eq(item).replaceWith(
								htmlString);
						} else {							
							$('#betting-data-table tbody').append(htmlString);
							addedCnt++;
						}
						
					}
					var updatedCount = data['data'].length;
					var removedCnt = 0;
					if(updatedCount < originalCount) {						
						for(i = originalCount - 1; i >= updatedCount; i--) {
							$('#betting-data-table tbody tr').eq(i).remove();
							removedCnt++;
						}						
					}
					
					// console.log('REMOVED: ', removedCnt);
					// console.log('ADDED: ', addedCnt);
					// console.log('current', $('#betting-data-table tbody tr').length);
				},
				error : function(e) {
				}
			});
}