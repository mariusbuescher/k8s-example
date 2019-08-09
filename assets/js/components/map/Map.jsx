import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import React, {useState, useContext, useEffect} from 'react';
import {Map, TileLayer, Marker, Popup} from 'react-leaflet';
import MapContext from "../../context/MapContext";

import schoolIcon from '../../../images/landmark-solid.svg';
import iconGridscale from '../../../images/gridscale-icon.svg';
import shadowIcon from 'leaflet/dist/images/marker-shadow.png';

function CologneMap(props) {
    const context = useContext(MapContext);

    const [schools, setSchools] = useState([]);
    const [north, setNorth] = useState(0);
    const [south, setSouth] = useState(0);
    const [west, setWest] = useState(0);
    const [east, setEast] = useState(0);

    const position = [context.lat, context.lng];

    const onMapChange = ({target}) => {
        context.setZoom(target.getZoom());
        context.setLat(target.getCenter().lat);
        context.setLng(target.getCenter().lng);

        setNorth(target.getBounds().getNorth());
        setSouth(target.getBounds().getSouth());
        setWest(target.getBounds().getWest());
        setEast(target.getBounds().getEast());
    };

    useEffect(() => {
        fetch('/schools/area?up_left_lat=' + north + '&up_left_long=' + west + '&bot_right_lat=' + south + '&bot_right_long=' + east)
            .then(res => res.json())
            .then((data) => {
                setSchools(data);
            });
    }, [north, south, east, west]);

    const icon = new L.Icon({
        iconUrl: schoolIcon,
        iconRetinaUrl: schoolIcon,
        iconAnchor: [20, 40],
        popupAnchor: [0, -35],
        iconSize: [20, 20],
        shadowUrl: shadowIcon,
        shadowSize: [9, 20],
        shadowAnchor: [7, 40],
    });

    const gridscaleIcon = new L.Icon({
        iconUrl: iconGridscale,
        iconRetinaUrl: iconGridscale,
        iconAnchor: [20, 40],
        popupAnchor: [0, -35],
        iconSize: [20, 20],
        shadowUrl: shadowIcon,
        shadowSize: [9, 20],
        shadowAnchor: [7, 40],
    });


    const markers = schools.map(school => {
        console.log([school.location.coordinates.lat, school.location.coordinates.long]);
        return (
            <Marker key={school.id} position={[school.location.coordinates.lat, school.location.coordinates.long]} icon={icon}>
                <Popup>
                    {school.name}<br/>
                    {school.education_connection.connection_type} with {school.education_connection.bandwidth} Mbit/s
                </Popup>
            </Marker>
        );
    });

    markers.push(
        <Marker key={"gridscale"} position={[50.947507, 6.905611]} icon={gridscaleIcon}/>
    );

    return (
        <Map center={position} zoom={context.zoom} onZoomend={onMapChange} onMoveend={onMapChange} onLoad={onMapChange}>
            <TileLayer
                attribution='&amp;copy <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
                url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
            />
            {markers}
        </Map>
    );
}

export default CologneMap