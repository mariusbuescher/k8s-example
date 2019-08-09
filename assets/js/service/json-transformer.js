const transformSchool = ({properties, geometry}) => ({
        name: properties.SCHOOL_NAME,
        has_wifi: properties.WLAN !== 0,
        location: {
            address: properties.ADDRESS,
            zip: properties.PLZ,
            district: properties.STADTBEZIRK,
            coordinates: {
                long: geometry.coordinates[0],
                lat: geometry.coordinates[1],
            },
        },
        management_connection: {
            bandwidth: properties.VERWALTUNG_BANDBREITE,
            connection_type: properties.VERWALTUNG_TECHNIK,
            is_symmetric: properties.VERWALTUNG_TYP !== "asymmetrisch",
        },
        education_connection: {
            bandwidth: properties.PAEDAGOGIK_BANDBREITE,
            connection_type: properties.PAEDAGOGIK_TECHNIK,
            is_symmetric: properties.PAEDAGOGIK_TYP !== "asymmetrisch",
        },
    });

const transformSchools = schools => schools.map(transformSchool);

export default transformSchools;
