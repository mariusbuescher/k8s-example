import React from 'react';

const ListContext = React.createContext({
    page: 1,
    pageSize: 10,
});

export default ListContext