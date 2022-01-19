Cube.date = function(format, offset){
    if(!offset) offset = 0;
    var d = new Date();
    var t = {};
    var dl = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
    


    
    // convert to msec
    // add local time zone offset 
    // get UTC time in msec
    utc = d.getTime() + (d.getTimezoneOffset() * 60000);
    
    // create new Date object for different city
    // using supplied offset
    d = new Date(utc + (3600000*offset));
    


    t.ms = d.getMilliseconds();
    t.Y = d.getFullYear();
    t.y = d.getYear();
    t.H = d.getHours();
    t.i = d.getMinutes();
    t.m = d.getMonth()+1;
    t.s = d.getSeconds();
    t.time = d.getTime();
    t.d = d.getDate();
    t.D = dl[d.getDay()];

    if(t.H<10) t.H = '0'+t.H;
    //if(t.h<10) t.h = '0'+t.h;
    if(t.i<10) t.i = '0'+t.i;
    if(t.m<10) t.m = '0'+t.m;
    if(t.d<10) t.d = '0'+t.d;
    if(t.s<10) t.s = '0'+t.s;
    if(t.d<10) t.H = '0'+t.H;
    if(!format) return t;
    var f = Cube.getType(format);
    if(f=='string'){
        var txt = format;
        txt = this.str.replace(txt,'ms',t.ms);
        txt = this.str.replace(txt,'time',t.time);
        txt = this.str.replace(txt,t);
        return txt;
    }
    return null;
};
Cube.getTimeSeconds = function (time){
    var xs = [1, 60, 3600];
    time = time?time:this.date('H:i:s');
    var times = time.split(':');
    var timeSeconds = 0;
    var c = times.length;
    if(c <= 3){
        var n = 0;
        for(var i = c-1; i >= 0; i--){
            var nb = parseInt(times[i]);
            timeSeconds+=nb*xs[n];
            n++;
        }
    }
    return timeSeconds;
}