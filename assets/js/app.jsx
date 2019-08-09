/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

require('bootstrap/dist/css/bootstrap.css');
require('../css/app.css');

import React from 'react';
import ReactDOM from 'react-dom';

import App from "./apps/App";

ReactDOM.render(
    <App/>,
    document.querySelector('#app')
);
