Cube.fn = function(){
    this.timeout_status = true;
    this.args_type = 'array';
    this.calling = null;
    this.system_list = {};
    
    this.disable_timeout = function(){
        this.timeout_status = false;
    };
    this.enable_timeout = function(){
        this.timeout_status = true;
        if(this.args_type=='list'){
            this.args_type = 'array';
        }
    };
    this.set_args_type = function(){
        var a = arguments;
        var t = 'array';
        var tt = 0;
        if(a.length>0){
            t = a[0];
        }
        if(typeof t == 'string'){
            var t2 = t.toLowerCase();
            if(t2!='array' && t2 != '0'){
                tt = 1;
            }
        }else if(t){
            tt = 1;
        }else{
            tt = 0;
        }
        if(tt){
            this.args_type = 'list';
            this.disable_timeout();
        }else{
            this.args_type = 'array';
        }
    };
    
    this.get_path = function(fn){
        if(!fn) return null;
        var t = Cube.getType(fn);
        var f = '';
        if(t=='function'){
            f = 'fn';
        }else if(t == 'string'){
            var a = Cube.str.replace(fn,' ','');
            if(!a) return null;
            
            if(Cube.getType(Cube.arr.get(this,a))=='function'){
                f = '_this.'+a;
            }
            else if(Cube.getType(Cube.arr.get(Cube,a))=='function'){
                f = 'Cube.'+a;
            }
            else{
                var func_paths = a.split('.');
                if(func_paths.length<2){
                    if(typeof window[a] == 'function'){
                        f = a;
                    }
                }else{
                    var kk = func_paths[0];
                    if(typeof window[kk] == 'object'){
                        var kz = '';
                        for(var i = 1; i < func_paths.length; i++){
                            var dt = '';
                            if(i>1) dt = '.';
                            kz+=(dt+func_paths[i]);
                            dt = '';
                        }
                        if(Cube.getType(Cube.arr.get(window[kk],kz))=='function'){
                            f = a;
                        }
                    }
                }
            }
        }
        return f;
    };
    this.get = function(fn){
        var r = function(){console.log(arguments);};
        if(!fn) return r;
        var t = Cube.getType(fn);
        var f = '';
		var _this = this;
        if(t=='function'){
            f = 'fn';
        }else if(t == 'string'){
            var fp = this.get_path(fn);
            if(fp){
                f = fp;
            }
        }
        
        if(f){
            eval('r = '+f+";");
        }
        return r;
    };
    this.check = function (fn){
        if(typeof fn != 'string') return false;
        // console.log(this.get_path(fn));
        if(this.get_path(fn)){
            return true
        }else return false;
    };
    this.add = function(func_name,fn,main){
        if(typeof func_name != 'string'|| typeof fn!='function') return false;
        var s = false;
        if(!this.system_list[func_name]){
            this[func_name] = fn;
            s = true;
        }
    
        
        return s;
    };
    this.remove = function(fn){
        if(typeof fn != 'string') return false;
        if(!this.system_list[fn] && typeof this[fn]=='function'){
            this[fn] = undefined;
            delete this[fn];
        }
        return true;
    };
    this.call = function(fn,args,time){
        if(!fn) return null;
        var t = Cube.getType(fn);
        var f = '';
        var agm = arguments;
        if(t=='function'){
            f = 'fn';
        }else if(t == 'string'){
            var fp = this.get_path(fn);
            if(fp){
                f = fp;
            }
        }
        if(!f) return undefined;
		var _this = this;
        var arg = [];
        if(this.args_type=='array'){
            if(typeof args!='undefined'){
                if(Cube.getType(args)=='array'){
                    arg = args;
                }else{
                    arg[0] = args;
                }
            }
        }else{
            var n = 0;
            for(var i=1; i< agm.length; i++){
                arg[n] = agm[i];
                n++;
            }
        }
		var t = arg.length;
        f+="(";
        for(var i = 0; i < t; i++){
            f+="arg["+i+"]";
            if(i < t-1) f+=",";
        }
        f+=");";
        var r = null;
        var o = "r = "+f;
        
        if(this.timeout_status && time){
            if(Cube.getType(time)=='number' && time > 0){
                this.calling = setTimeout(function(){
                    eval(o);
                    return r;
                },time);
                return true;
            }
        }
        eval(o);
        return r;
    };
    this.parse = function (fn){
        var f = function(){
            
        };
        if(!fn) return f;
        var t = Cube.getType(fn);
        
        if(t=='function'){
            f = fn;
        }
        else if(t=='string'){
            if(this.check(fn)){
                f = this.get(fn);
            }
        }
        return f;
    };
    this.go_to = function (url){
        window.open(url,'_blank');
    };
    
    this.open_window = function (url,title,width,height,x,y){
        var swidth = screen.width,
            sheight = screen.height;
        if(!width) width = 600;
        if(!height) height = 300;
        var left = (x)?x:((swidth - width) / 2),
            top = (y)?y:((sheight - height)/2 - 100);
        if(top<0) top = 0;
        if(!title) title = 'Blank Page';
        window.open(url,title,'targetWindow,toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width='+width+',height='+height+',top='+top+',left='+left);
    };
    var a = this;
    var st = {};
    for(var k in a){
        st[k] = k;
    }
    this.system_list = st;
};

