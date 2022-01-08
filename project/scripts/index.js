function doSomething(formData) {

    var obj = O(formData)
    var latitude = Number.parseFloat(obj.elements['latitude'].value)
    var panel_slope = Number.parseFloat(obj.elements['panel'].value)
    var rate = Number.parseFloat(obj.elements['rate'].value)
    var month = obj.elements['months'].selectedIndex + 1
    var filler = 1

    var values = [latitude, panel_slope, rate, month, filler]

    for (let i = 0; i < values.length; i++) {
        if (values[i].isNan || values[i] == "") {
            alert('Empty value not accepted')
            return
        }
    }

    var valuesObj = {
        'latitude': latitude,
        'panel_slope': panel_slope,
        'rate': rate,
        'month': month,
        'rate': filler
    }

    // calculations = computeAngles(valuesObj)
    // calculations.ratedWatts = rate

    valuesObj.rate = findWatts(computeAngles(valuesObj))
    values[values.length - 1] = valuesObj.rate
    var table = O('table')
    var str = table.innerHTML

    str += '<div class="row">'
    for (let i = 0; i < 5; i++) {
        str += '<div class="cell">' + values[i] + '</div>'
    }
    str += '</div>'
    table.innerHTML = str
}

function computeAngles(arg) {
    var latitude = arg.latitude * Math.PI / 180
    var panelSlope = arg['panel_slope'] * Math.PI / 180
    var month = arg.month
    var solarDeclination = (-23.45 * Math.PI / 180) * Math.cos(month * Math.PI / 6)
    var cosAzimuth
    var sinAltitude = Math.cos(latitude) * Math.cos(solarDeclination) +
        Math.sin(latitude) * Math.sin(solarDeclination)

    var altitude = Math.asin(sinAltitude)

    if (altitude > 0) {
        cosAzimuth =
            (Math.sin(solarDeclination) - sinAltitude * Math.sin(latitude)) / (Math.cos(altitude) * Math.cos(latitude))

        cosIncidenceAngle = sinAltitude * Math.cos(panelSlope) -
            cosAzimuth * Math.cos(altitude) * Math.sin(panelSlope)

        if (cosIncidenceAngle < 0) {
            cosIncidenceAngle = 0.0
        }
    }
    return {
        'solarDeclination': solarDeclination,
        'cosAzimuth': cosAzimuth,
        'sinAltitude': sinAltitude,
        'altitude': altitude,
        'cosIncidenceAngle': cosIncidenceAngle
    }
}

function findWatts(calculations) {
    var ratedWatts
    var watts = 0

    ratedWatts = calculations['ratedWatts']
    var altitude = Math.asin(calculations.sinAltitude)

    if (altitude > 0) {
        watts = ratedWatts *
            (0.86 * calculations['cosIncidenceAngle'] + 0.14 * Math.sin(calculations['altitude']))
    }

    return Math.round(watts)

}