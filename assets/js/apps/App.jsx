import ListContext from "../context/ListContext";
import {BrowserRouter, Link, Route} from "react-router-dom";
import {Col, Container, Nav, Navbar, Row} from "react-bootstrap";
import Map from "../pages/Map";
import List from "../pages/List";
import Upload from "../pages/Upload";
import MapContext from "../context/MapContext";
import React, {useState} from "react";

function App() {
    const [zoom, setZoom] = useState(15);
    const [lat, setLat] = useState(50.9529005);
    const [lng, setLng] = useState(6.9570957);

    const defaultMapContextValue = {
        zoom,
        lat,
        lng,
        setZoom,
        setLat,
        setLng,
    };

    const defaultListContext = {
        page: 1,
        pageSize: 10,
    };

    return (
        <MapContext.Provider value={defaultMapContextValue}>
            <ListContext.Provider value={defaultListContext}>
                <BrowserRouter>
                    <Container>
                        <Row>
                            <Navbar>
                                <Link to="/" className="navbar-brand">Schools in Cologne</Link>
                                <Navbar.Collapse>
                                    <Nav>
                                        <Link to="/" className="nav-link">Map</Link>
                                        <Link to="/upload/" className="nav-link">Upload data</Link>
                                        <Link to="/list/" className="nav-link">List</Link>
                                    </Nav>
                                </Navbar.Collapse>
                            </Navbar>
                        </Row>
                        <Row>
                            <Col>
                                <Route path="/" exact component={Map}/>
                                <Route path="/list/" component={List}/>
                                <Route path="/upload/" component={Upload}/>
                            </Col>
                        </Row>
                    </Container>
                </BrowserRouter>
            </ListContext.Provider>
        </MapContext.Provider>
    );
}

export default App