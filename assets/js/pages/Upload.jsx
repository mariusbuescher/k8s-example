import React, {useState} from "react";

import {Form, Button, Alert} from "react-bootstrap";

import transformSchools from "../service/json-transformer";

function Upload() {
    const [isSuccess, setIsSuccess] = useState(null);
    const [countImported, setCountImported] = useState(0);
    const fileRef = React.createRef();

    function handleFileUpload() {
        const reader = new FileReader();

        reader.addEventListener('load', () => {
            const schools = JSON.parse(reader.result).features;

            fetch(new Request('/schools/batch', {
                method: 'POST',
                body: JSON.stringify(transformSchools(schools)),
            })).then(res => res.json())
                .then(({count}) => {
                    setIsSuccess(true);
                    setCountImported(count);
                }).catch(() => {
                    setIsSuccess(false);
                });
        });

        reader.readAsText(fileRef.current.files[0]);
    }
    
    function renderMessage(success, count) {
        if (success === true) {
            return (
                <Alert variant="success">Successfully imported {count} schools.</Alert>
            );
        } else if (success === false) {
            return (
                <Alert variant="danger">There was a problem importing the schools.</Alert>
            );
        } else {
            return '';
        }
    }

    return (
        <Form onSubmit={(e) => {
            handleFileUpload();
            e.preventDefault();
        }}>
            {renderMessage(isSuccess, countImported)}
            <Form.Group>
                <Form.Label>Data file</Form.Label>
                <Form.Control ref={fileRef} type="file"/>
                <Form.Text className="text-muted">
                    The data file in JSON format provided by <a href="https://offenedaten-koeln.de/dataset/bandbreitenuebersicht-schulen-koeln" target="_blank">Offene Daten Köln</a>.
                </Form.Text>
            </Form.Group>
            <Button type="submit">Upload</Button>
        </Form>
    )
}

export default Upload