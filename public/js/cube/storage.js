Cube.storage = {
    support: function() {
        if (typeof(Storage) !== "undefined") {
            return true;
        }
        return true;
    },
    set: function(key,value){
        if(!this.support()) return false;
        localStorage.setItem(key, value);
        return true;
    },
    get: function(key){
        if(!this.support()) return null;
        var val = localStorage.getItem(key);
        return val;
    },
    remove: function(key){
        if(!this.support()) return false;
        localStorage.removeItem(key);
        return true;
    }
};