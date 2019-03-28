var PROTOCOLS = location.protocol;
var DOMAIN = window.location.host;

var domain = function () {
    return PROTOCOLS + '//' + DOMAIN;
};

var getAbsolutePath = function () {
    var PATHNAME = window.location.pathname;
    return domain() + PATHNAME;
};

var loginUser = function ( id ) {
    var controller = domain() + '/supplant/' + id;
    window.location.replace( controller );
};

var searchuser = function () {
    var buscar = $( '#buscar' ).val();

    if( buscar.length === 0 ){
        window.location.replace( getAbsolutePath() );
    }

    if( buscar.length > 3 ){
        window.location.replace( getAbsolutePath() + '?buscar=' + buscar );
    }

};
