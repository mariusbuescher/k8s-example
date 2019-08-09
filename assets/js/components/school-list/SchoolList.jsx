import React from 'react';

function Table(props) {
    const schools = props.schools;

    return (
        <table className="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Address</th>
                    <th scope="col">District</th>
                    <th scope="col">Bandwidth</th>
                    <th scope="col">Wifi?</th>
                </tr>
            </thead>
            <tbody>
            {schools.map((school) => {
                return (
                    <tr key={school.id}>
                        <td>{school.name}</td>
                        <td>
                            {school.location.address}<br/>
                            {school.location.zip}
                        </td>
                        <td>{school.location.district}</td>
                        <td>{school.education_connection.bandwidth} Mbit/s</td>
                        <td>{school.has_wifi ? 'Yes' : 'No'}</td>
                    </tr>
                )
            })}
            </tbody>
        </table>
    )
}

export default Table