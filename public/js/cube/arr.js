
Cube.arr = {
    delimiter : '.',
    getType : function (obj){
        var t = 'null';
        if(typeof obj=='object'){
            if(obj==null){
                t = 'null';
            }else if(obj.constructor==FormData){
                t = 'formdata';
            }else if(obj.constructor==Array){
                t = 'array';
            }else if(obj.constructor==Object){
                t = 'object';
            }else if(obj.constructor==Number){
                t = 'number';
            }else{
                t = 'object';
            }
        }else{
            t = typeof obj;
        }
        return t;
    },
    is_arr : function (obj){
        if(typeof obj == 'undefined'){
            return false;;
        }
        var t = this.getType(obj);
        if(t!='object'&&t!='array') return false;
        return true;
    },
    isArr : function(obj){
        if(typeof obj == 'undefined'){
            return false;
        }
        var t = this.getType(obj);
        if(t=='array') return true;
        return false;
    },
    isObj : function(obj){
        if(typeof obj == 'undefined'){
            return false;
        }
        var t = this.getType(obj);
        if(t=='object') return true;
        return false;
    },
    to_obj : function (obj){
        if(typeof obj == 'undefined'){
            return {};
        }
        var t = this.getType(obj);
        if(t!='object'&&t!='array') return {"0":obj};
        if(t=='array'){
            var na = {};
            for(var k in obj){
                var v = obj[k];
                na[k] = v;
            }
            return na;
        }
        return obj;
    },
    to_arr : function(obj){
        if(typeof obj == 'undefined'){
            return [];
        }
        var t = this.getType(obj);
        var arr = obj;
        if(t!='object'&&t!='array') return [arr];
        if(t=='object'){
            var na = [];
            var i = 0;
            for(var k in arr){
                var v = arr[k];
                na[i] = v;
                i++;
            }
            return na;
        }
        return arr;
    },
    count : function(obj){
        if(typeof obj == 'undefined'){
            return 0;
        }
        var t = this.getType(obj);
        if(t=='object'){
            var i = 0;
            for(var k in obj){
                i++;
            }
            return i;
        }
        else if(t=='array'){
            return obj.length;
        }
        else{
            return 0;
        }
    },
    join : function(delimiter,arr,rtrim){
        if(typeof arr == 'undefined'){
            arr = [];
        }
        
        if(!delimiter) delimiter = ' ';
        if(!rtrim && rtrim!=false) rtrim = true;
        var str = '';
        var t = this.count(arr);
        if(t>0){
            arr.join(delimiter);
            if(!rtrim) arr+=delimiter;
        }
        return str;
    },
    split : function (delimiter,str){
        var td = typeof delimiter;
        var ta = typeof str;
        if(!delimiter || (td!='string' && td != 'number') ) delimiter = '';
        if(ta!='string') return str;
        return str.split(delimiter);
    },
    add_width_auto_key : function(arr,val){
        if(typeof arr == 'undefined'){
            return [val];
        }
        var t = this.getType(arr);
        if(t!='object'&&t!='array'){
            return this;
        }
        var k = this.maxIndex(arr);
        if(!isNaN(k)) k++;
        else k = 0;
        arr[k] = val;
        return arr;
    },
    add_a_arr : function (main,arr){
        if(typeof main == 'undefined'){
            return this.to_arr(arr);
        }
        var t = this.getType(main);
        if(typeof arr == 'undefined'){
            return main;
        }
        var tm = this.getType(arr);
        if((t=='array'||t=='object')&&(tm=='array'||tm=='object')){
            for(var k in arr){
                var v = arr[k];
                main = this.add_width_auto_key(v,main);
            }
        }
        return main;
    },
    add_a_obj : function (main,arr){
        if(typeof main == 'undefined'){
            return this.to_obj(arr);
        }
        var t = this.getType(main);
        if(typeof arr != 'undefined'){
            var ta = this.getType(arr);
            if((t=='array'||t=='object')&&(ta=='array'||ta=='object')){
                if(t!='object') main = this.to_obj(main);
                for(var k in arr){
                    var v = arr[k];
                    main[k] = v;
                }
            }
        }
        return main;
    },
    add : function(arr,val,val2,delimiter){
        var tv = typeof val;
        var isThis1 = false;
        if(typeof arr == 'undefined'){
            return null;
        }
        var t = typeof arr;
        if(t!='object') arr = {};
        t = this.getType(arr);
        if(val && val2){
            if(tv=='string'){
                if(!delimiter || td!='string' || td == 'undefine') delimiter = '.';
                var key = val;
                var keys = key.split(delimiter);
                var v = null;
                if(t!="object") arr = this.to_obj(arr);
                var d = arr;
                var strk = "arr";
                var stre = '';
                for(var i = 0; i < keys.length; i++){
                    var k = keys[i];
                    if(i<keys.length-1){
                        if(typeof d[k] == 'undefined'){
                            strk += '["'+k+'"]';
                            stre += strk + " = {};";
                        }
                        else{
                            switch(this.getType(d[k])){
                                case 'object':
                                    strk += '["'+k+'"]';
                                break;
                                case 'array':
                                    strk += '["'+k+'"]';
                                    stre += strk + " = this.to_obj("+strk+");";
                                break;
                                case 'undefined':
                                    strk += '["'+k+'"]';
                                    stre += strk + " = {};";
                                break;
                                default:
                                    strk += '["'+k+'"]';
                                    stre += strk + " = {};";
                                break
                            }
                        }
                    }
                    else{
                        strk += '["'+k+'"] = val2;';
                    }
                }
                var e = stre+strk;
                //console.log(e);
                eval(e);
            }
            else if(tv=='number'){
                if(t=='array'){
                    if(arr.length>=val){
                        arr[val] = val2;
                    }
                    else{
                        arr = this.to_obj(arr);
                        arr[val] = val2;
                    }
                }
            }
            else{
                if(this.isObj(val)){
                    for(var kk in val){
                        var vv = val[kk];
                        arr[kk] = vv;
                    }
                }
                else if(this.isArr(val)){
                    arr = this.add_a_arr(arr,val);
                }else{
                    arr = this.add_width_auto_key(arr,val);
                }
                if(this.isObj(val2)){
                    arr = this.add_a_obj(arr,val2);
                }else if(this.isArr(val2)){
                    arr = this.add_a_arr(arr,val);
                }else{
                    arr = this.add_width_auto_key(arr, val2);
                }
                if(delimiter){
                    if(this.isObj(delimiter)){
                        arr = this.add_a_obj(arr,delimiter);
                    }
                    else if(this.isArr(delimiter)){
                        arr = this.add_a_arr(arr,delimiter);
                    }
                    else{
                        arr = this.add_width_auto_key(arr,delimiter);
                    }
                }
            }
        }
        else if(val && typeof val2 == 'undefined'){
            var g = this.getType(val);
            switch(g){
                case 'array':
                    arr = this.add_a_arr(arr,val);
                break;
                case 'object':
                    arr = this.add_a_obj(arr,val);
                break;
                default:
                    arr = this.add_width_auto_key(arr,val);
                break;
            }
        }
        else if((tv=='undefined'||val==null) && val2){
            arr = this.add_width_auto_key(arr,val2);
        }
        return arr;
    },
    
    remove_by_simple_key : function(obj, key){
        if(typeof obj == 'undefined'){
            return null;
        }
        if(typeof key == 'undefined'){
            obj = null;
        }
        else{
            var t = this.getType(obj);
            var tk = getType(key);
            
            if(t=='array'){
                if(tk!='number'){
                    var tkx = parseInt(key);
                    if(!isNaN(tkx)){
                        key = tkx;
                    }
                    if(!isNaN(key)){
                        if(key<obj.length){
                            obj.splice(key,1);
                        }
                    }
                }
                else{
                    if(key<obj.length){
                        obj.splice(key,1);
                    }
                }
            }
            else if(t=='object'){
                delete obj[key];
            }
        }
        return obj;
    },
    remove_by_val : function(obj,val){
        if(typeof obj == 'undefined'){
            return null;
        }
        var t = this.getType(obj);
        if(t=='array'){
            var n = [];
            var i = 0;
            for(var k in obj){
                if(obj[k]!=val){
                    n[i] = obj[i];
                    i++;
                }
            }
            obj = n;
        }else if(t=='object'){
            var n = {};
            for(var k in obj){
                if(obj[k]!==val){
                    n[k] = obj[k];
                }
            }
            obj = n;
        }
        return obj;
    },
    remove : function(obj,key){
        if(typeof obj == 'undefined'){
            return null;
        }
        if(typeof key == 'undefined'){
            obj = [];
        }else{
            var t = this.getType(obj);
            if(t=='array'){
                obj = this.remove_by_simple_key(obj,key);
            }
            else if(t=='object'){
                var tk = this.getType(key);
                if(tk == 'number'){
                    obj = this.remove_by_simple_key(obj,key);
                }
                else if(tk=='string'){
                    var d = this.delimiter;
                    var td = this.getType(d);
                    if(td!="string"&&td!="number"){
                        d = '.';
                    }
                    var ks = key.split(d);
                    if(ks.length==1){
                        obj = this.remove_by_simple_key(obj,key);
                    }else{
                        var o = obj;
                        var s = true;
                        var strk = "obj";
                        for(var i = 0; i < ks.length; i++){
                            var k = ks[i];
                            if(typeof o[k] == 'object'){
                                o = o[k];
                                strk += "[\""+k+"\"]";
                            }else{
                                s = false;
                                break;
                            }
                        }
                        if(s){
                            var lop = this.remove_by_simple_key(o,ks[ks.length-1]);
                            eval(strk+" = lop;");
                        }
                    }
                }
            }
        }
        return obj;
    },
    get : function(obj,key,delimiter){
        if(typeof obj =='undefined'){
            return null;
        }
        if(typeof key == 'undefined'){
            return obj;
        }
        var tpo = this.getType(obj);
        var tpk = this.getType(key);
        if(tpo=='array'){
            var k = NaN;
            if(tpk == 'number'){
                k = key;
            }else if(parseInt(key)!=NaN){
                k = parseInt(key);
            }
            if(!isNaN(k)){
                if(typeof obj[k]!='undefined'){
                    return obj[k];
                }
            }
        }else if(tpo=='object'){
            if(tpk=='number'){
                if(typeof obj[key]!='undefined'){
                    return obj[key];
                }
            }else if(tpk=='string'){
                if(typeof delimiter == 'undefined'){
                    delimiter = this.delimiter;
                }else{
                    var t = this.getType(delimiter);
                    if(t!='string'&&t!='number'){
                        delimiter = this.delimiter;
                    }
                }
                var _keys = key.split(delimiter);
                var d = obj;
                for(var i = 0; i < _keys.length; i++){
                    var k = _keys[i];
                    if(typeof d[k] != 'undefined'){
                        d = d[k];
                    }else{
                        d = null;
                        i+=_keys.length;
                    }
                }
            }
            return d;
        }
        return null;
    },
    isSet : function(obj,key){
        if(typeof obj =='undefined'){
            return false;
        }
        if(typeof key == 'undefined'){
            return obj?true:false;
        }
        
        var tpo = this.getType(obj);
        var tpk = this.getType(key);
        var stt = false;
        if(tpo=='array'){
            var k = NaN;
            if(tpk == 'number'){
                k = key;
            }else if(parseInt(key)!=NaN){
                k = parseInt(key);
            }
            if(!isNaN(k)){
                if(typeof obj[k]!='undefined'){
                    return true;
                }
            }
        }else if(tpo=='object'){
            if(tpk=='number'){
                if(typeof obj[key]!='undefined'){
                    return true;
                }
            }else if(tpk=='string'){
                if(typeof delimiter == 'undefined'){
                    delimiter = this.delimiter;
                }else{
                    var t = this.getType(delimiter);
                    if(t!='string'&&t!='number'){
                        delimiter = this.delimiter;
                    }
                }
                var _keys = key.split(delimiter);
                var d = obj;
                for(var i = 0; i < _keys.length; i++){
                    var k = _keys[i];
                    if(typeof d[k] != 'undefined'){
                        d = d[k];
                        stt = true;
                    }else{
                        d = null;
                        stt = false;
                        i+=_keys.length;
                    }
                }
            }
            return stt;
        }
        return stt;
    },
    inArr : function (arr,val,key,delimiter){
        if(typeof arr == 'undefined'){
            return null;
        }
        if(typeof key != 'undefined'){
            if(typeof delimiter == 'undefined'){
                delimiter = this.delimiter;
            }else{
                var t = this.getType(delimiter);
                if(t!='string'&&t!='number'){
                    delimiter = this.delimiter;
                }
            }
            
            arr = this.get(arr,key,delimiter);
        }
        var t = this.getType(arr);
        if(t!='object'&&t!='array') return null;
        for(var k in arr){
            var v = arr[k];
            if(v==val) return true;
        }
        return false;
    },
    maxIndex : function (obj){
        if(typeof obj == 'undefined'){
            return NaN;
        }
        var t = this.getType(obj);
        if(t=='array'){
            return obj.length - 1;
        }else if(t == 'object'){
            var po = [];
            var i = 0;
            for(var k in obj){
                var f = parseInt(k);
                if(!isNaN(f)){
                    po[i] = f;
                    i++;
                }
            }
            var b = this.maxInt(po);
            return b;
        }
        return -1;
    },
    maxInt : function (arr){
        var t = typeof arr;
        if(t=='undefined'){
            return NaN;
        }
        t = this.getType(arr);
        if(t!='object'&&t!='array') return null;
        var intArr = [];
        var i = 0;
        for(var k in arr){
            var v = parseInt(arr[k]);
            if(!isNaN(v)){
                intArr[i] = v;
                i++;
            }
        }
        if(typeof intArr[0] !='undefined'){
            var max = intArr[0];
            for(var j = 1; j < intArr.length; j ++){
                max = (max>intArr[j])?max:intArr[j];
            }
            return max;
        }
        return NaN;
    },
    to_row_arr : function (obj,key_of_key,key_of_val){
        if(typeof obj =='object' && typeof key_of_key == 'string' && typeof key_of_val == 'string'){
            var a = [];
            var i = 0;
            for(var key in obj){
                var val = obj[key];
                var ai = {};
                ai[key_of_key] = key;
                ai[key_of_val] = val;
                a[i] = ai;
                i++;
            }
            return a;
        }
        return obj;
    },
    to_row_obj : function (obj,key_of_key,key_of_val){
        if(typeof obj =='object' && typeof key_of_key == 'string' && typeof key_of_val == 'string'){
            var a = {};
            var i = 0;
            for(var key in obj){
                var val = obj[key];
                var ai = {};
                ai[key_of_key] = key;
                ai[key_of_val] = val;
                a[i] = ai;
                i++;
            }
            return a;
        }
        return obj;
    },
};
