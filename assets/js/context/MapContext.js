import React from 'react';

const MapContext = React.createContext({
    zoom: 15,
    lat: 50.9529005,
    lng: 6.9570957,
    setZoom: () => {},
    setLat: () => {},
    setLng: () => {},
});

export default MapContext