import moment from 'moment';
Vue.filter( 'formatPrice', function ( value ) {
    if( ! value ) {
        value = 0;
    }
    let newValue = parseFloat( value );
    return 'S/ ' + ( newValue.toFixed(2) );
});

Vue.filter( 'formatDate', function( value ) {
    if ( value ) {
        return moment( String( value ) ).format( 'DD/MM/YYYY' );
    }
});

Vue.filter( 'formatStock', function ( value, unity ) {
   if ( ! value ) {
       value = 0;
   }
   return value + ' ' + unity;
});
