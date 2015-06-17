/**
 * Created by gento on 22/5/2015.
 */
var sub_view_url = function(file){
    var asset_url = base_url + '/assets/subviews';
    if(!file){
        file = '';
    }
    return asset_url + '/' + file;
};