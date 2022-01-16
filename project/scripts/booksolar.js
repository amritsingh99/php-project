function addRow(param) {
    console.log(param);
    var table = O(param)
    row = table.insertRow()
        // console.log(row);
        // console.log(row.cell.length)
    console.log(table.rows[1]);
    console.log(table)
}

function calc(param) {
    var calculation = {
        latitude: param.elements['latitude'].value,
        panelSlope: param.elements['panelSlope'].value,
        ratedWatts: param.elements['ratedWatts'].value,
        month: param.elements['months'].value,
        filler: 1
    }

    var monthIndex = param.elements['months'].selectedIndex + 1
    calculation.monthIndex = monthIndex
    var table = O('performance')

    var row = table.insertRow()

    row.insertCell(0).innerHTML = calculation.latitude
    row.insertCell(1).innerHTML = calculation.panelSlope
    row.insertCell(2).innerHTML = calculation.ratedWatts
    row.insertCell(3).innerHTML = calculation.month
    row.insertCell(4).innerHTML = calculation.filler

    result = computeAngles(calculation)
    console.log(result);
}

// function computeAngles(angles) {
//     var latitude = angles.latitude * Math.PI / 180;
//     var panelSlope = angles.panelSlope * Math.PI / 180;;
//     var month = angles.monthIndex
//     var solarDeclination = (-23.45 * Math.PI / 180) * Math.cos(month * Math.PI / 6);
//     console.log("solarDeclination " + solarDeclination);
//     var cosAzimuth
//     var sinAltitude = Math.cos(latitude) * Math.cos(solarDeclination) +
//         Math.sin(latitude) * Math.sin(solarDeclination);

//     var altitude = Math.asin(sinAltitude)
//     var cosIncidenceAngle
//     if (altitude > 0) {
//         cosAzimuth =
//             (Math.sin(solarDeclination) - sinAltitude * Math.sin(latitude)) /
//             (Math.cos(altitude) * Math.cos(latitude));
//         cosIncidenceAngle = sinAltitude * Math.cos(panelSlope) - cosAzimuth *
//             Math.cos(altitude) * Math.sin(panelSlope)
//         if (cosIncidenceAngle < 0) {
//             cosIncidenceAngle = 0.0
//         }
//     }

//     return {
//         'solarDeclination': solarDeclination,
//         'cosAzimuth': cosAzimuth,
//         'sinAltitude': sinAltitude,
//         'altitude': altitude,
//         'cosIncidenceAngle': cosIncidenceAngle
//     }
// }

function findWatts() {

}