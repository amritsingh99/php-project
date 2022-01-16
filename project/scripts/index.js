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
        'ratedWatts': rate,
        'month': month,
        'rate': filler
    }

    var calculations = computeAngles(valuesObj)
    calculations.watts = findWatts(calculations)
    values[values.length - 1] = calculations.watts
    console.log(calculations);

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
    var cosIncidenceAngle
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
        'cosIncidenceAngle': cosIncidenceAngle,
        'ratedWatts': arg.rate
    }
}

function findWatts(calculations) {
    var ratedWatts
    var watts = 0

    ratedWatts = calculations['ratedWatts']
    var altitude = calculations.altitude
    if (altitude > 0) {
        watts = ratedWatts *
            (0.86 * calculations['cosIncidenceAngle'] + 0.14 * Math.sin(calculations['altitude']))
        console.log(watts);
    }

    return Math.round(watts)

}

function findRoots(formData) {
    var obj = O(formData)
    var a = Number.parseInt(obj.elements['a'].value)
    var b = Number.parseInt(obj.elements['b'].value)
    var c = Number.parseInt(obj.elements['c'].value)

    if (Number.isNaN(a) || Number.isNaN(b) || Number.isNaN(c)) {
        alert('Empty values not accepted')
        return
    }

    var str = obj.innerHTML

    var D = b * b - 4 * a * c
    if (D < 0) {
        str += "<p>Roots are imaginary</p>"
    }
    if (D == 0) {
        str += "<p>Roots are equal</p>"
        var root = -b / (2.0 * a)
        str += "<p>Roots are " + root + ", " + root + " </p>"
    }
    if (D > 0) {
        str += "<p>Roots are distinct</p>"
        var root1 = (-b + D) / (2.0 * a)
        var root2 = (-b - D) / (2.0 * a)
        str += "<p> root1: " + root1 + " <br>root2: " + root2 + "</p>"
    }
    obj.innerHTML = str;
    return
}

function generateTable(formData) {

    var deposit = Number.parseFloat(formData.elements['deposit'].value)
    var years = Number.parseFloat(formData.elements['years'].value)
    var rate = Number.parseFloat(formData.elements['rate'].value)
    var year = 1
    var amount = deposit
    var table =
        `<table>
    <tr>
        <th>Year</th>
        <th>Starting Value</th>
        <th>Interest Earned</th>
        <th>Ending Value</th>
    </tr>`


    while (year <= years) {
        table += "<tr>";
        table += "<td>" + year + "</td>";
        table += "<td>$" + amount.toFixed(2) + "</td>";
        interest = amount * rate / 100;
        table += "<td>$" + interest.toFixed(2) + "</td>";
        amount += interest;
        table += "<td>$" + amount.toFixed(2) + "</td>";
        table += "</tr>";
        year++;
    }
    table += "</table>"
    document.getElementById('result').innerHTML = table
}

function amrit() {
    var x = (element) => {
        console.log(element)
    }
    x("Amrit")
}

// amrit()