var summary = Object.values(js_summary);

window.addEventListener("load", (event) => {
    draw();
});

window.addEventListener("resize", (event) => {
    draw();
});

function draw() {
    var svg = document.getElementsByClassName("graph");
    var svg_info = document.getElementById('graph-info');

    draw_clear(svg, svg_info);

    draw_scale(svg_info);

    for (let i = 0; i < svg.length; i++) {
        draw_background(svg[i]);

        if (summary[i]) {
            var date = Object.values(summary[i]);
            date.pop(); //break;
            date.pop(); //working;

            date.forEach(record => {
                draw_record(svg[i], record);
            });
        }
    }
}

function draw_clear(svg, svg_info) {
    for (let i = 0; i < svg.length; i++){
        if (svg[i].childNodes) {
            for (var j =svg[i].childNodes.length-1; j>=0; j--) {
                svg[i].removeChild(svg[i].childNodes[j]);
            }
        }
    }
    if (svg_info.childNodes) {
        for (var i = svg_info.childNodes.length - 1; i >= 0; i--) {
            svg_info.removeChild(svg_info.childNodes[i]);
        }
    }
}


function draw_record(area, record) {

    var graph_zero = new Date(record['date'] + ' 05:00:00');
    var graph_end = new Date(record['date'] + ' 24:00:00');
    var graph_width = graph_end.getTime() - graph_zero.getTime();
    var graph_margin = 10;

    var round = document.createElementNS("http://www.w3.org/2000/svg", "rect");

    switch (record['type']) {
        case 'Working':
            var start_time = new Date(record['date'] + ' ' + record['start']);
            var finish_time = new Date(record['date'] + ' ' + record['finish']);
            round.setAttributeNS(null,"fill", "#2384CF");
            break;
        case 'Breaking':
            var start_time = new Date(record['date'] + ' ' + record['break_start']);
            var finish_time = new Date(record['date'] + ' ' + record['break_finish']);
            round.setAttributeNS(null,"fill", "#CC232E");
            break;
    }

    var bar_start = Math.floor((start_time.getTime() - graph_zero.getTime()) * area.clientWidth / graph_width);
    var bar_width = Math.floor((finish_time.getTime() - start_time.getTime()) * area.clientWidth / graph_width);

    round.setAttributeNS(null,"x", bar_start);
    round.setAttributeNS(null,"y", graph_margin);
    round.setAttributeNS(null,"width", bar_width);
    round.setAttributeNS(null,"height", area.clientHeight - (graph_margin * 2));
    area.appendChild(round);

    if (record['type'] == 'Working') {
        var time_text_s = document.createElementNS("http://www.w3.org/2000/svg", "text");
        time_text_s.setAttributeNS(null, "x", bar_start);
        time_text_s.setAttributeNS(null, "y", area.clientHeight/2);
        time_text_s.setAttributeNS(null, "alignment-baseline", 'middle');
        time_text_s.setAttributeNS(null, "font-size", "12px");
        time_text_s.setAttributeNS(null, "text-anchor", 'end');
        time_text_s.textContent = start_time.getHours().toString().padStart(2,'0') + ':' + start_time.getMinutes().toString().padStart(2,'0');
        area.appendChild(time_text_s);

        var time_text_f = document.createElementNS("http://www.w3.org/2000/svg", "text");
        time_text_f.textContent = finish_time.getHours().toString().padStart(2,'0') + ':' + finish_time.getMinutes().toString().padStart(2,'0');
        time_text_f.setAttributeNS(null, "x", bar_start + bar_width);
        time_text_f.setAttributeNS(null, "y", area.clientHeight/2);
        time_text_f.setAttributeNS(null, "alignment-baseline", 'middle');
        time_text_f.setAttributeNS(null, "text-anchor", 'start');
        time_text_f.setAttributeNS(null, "font-size", "12px");
        area.appendChild(time_text_f);
    }

}

function draw_background(area) {
    var background = document.createElementNS("http://www.w3.org/2000/svg", "rect");
    background.setAttributeNS(null,"fill", '#FFFFFF');
    background.setAttributeNS(null,"x", 0);
    background.setAttributeNS(null,"y", 0);
    background.setAttributeNS(null,"width", area.clientWidth);
    background.setAttributeNS(null, "height", area.clientHeight);
    area.appendChild(background);

    for (let i = 5; i < 25; i++){
        draw_border(area, i);
    }

}

function draw_border(area, time) {

    var scale_bar = document.createElementNS("http://www.w3.org/2000/svg", "line");
    scale_bar.setAttributeNS(null, 'x1', area.clientWidth * ((time - 5) / 19) );
    scale_bar.setAttributeNS(null, 'y1', 0);
    scale_bar.setAttributeNS(null, 'x2', area.clientWidth * ((time - 5) / 19));
    scale_bar.setAttributeNS(null, 'y2', area.clientHeight);
    switch (time) {
        case 9:
        case 12:
        case 18:
            scale_bar.setAttributeNS(null, 'stroke', '#909090');
            scale_bar.setAttributeNS(null, 'stroke-width', '2px');
            break;
        default:
            scale_bar.setAttributeNS(null, 'stroke', '#E3E6E9');
            scale_bar.setAttributeNS(null, 'stroke-width', '1px');
    }
    area.appendChild(scale_bar);
}


function draw_scale(svg_info) {
    draw_info(svg_info, 5, 'start');
    draw_info(svg_info, 9, 'middle');
    draw_info(svg_info, 12, 'middle');
    draw_info(svg_info, 18, 'middle');
    draw_info(svg_info, 24, 'end');
}

function draw_info(area, time, anchor) {
    var scale_text= document.createElementNS("http://www.w3.org/2000/svg", "text");
    scale_text.textContent = time;
    scale_text.setAttributeNS(null, "x", area.clientWidth*((time-5)/19));
    scale_text.setAttributeNS(null, "y", 10);
    scale_text.setAttributeNS(null, "alignment-baseline", 'middle');
    scale_text.setAttributeNS(null, "text-anchor", anchor);
    scale_text.setAttributeNS(null, "font-size", "14px");
    scale_text.setAttributeNS(null, "font-weight", "bold");
    area.appendChild(scale_text);
}
