import React from 'react';
import {Pagination as BootstrapPagination} from "react-bootstrap";

function Pagination(props) {
    const numOfPages = props.total;
    const currentPage = props.current;
    const onPageChange = props.onPageChange;

    const items = [];
    const firstPage = Math.max(currentPage - 2, 1);
    const lastPage = Math.min(currentPage + 2, numOfPages);

    if (currentPage > 1) {
        items.push(
            <BootstrapPagination.Item key="prev" onClick={() => {
                onPageChange(currentPage - 1)
            }}>&laquo;</BootstrapPagination.Item>
        );
    }

    for (let i = firstPage; i <= lastPage; i++) {
        items.push((
            <BootstrapPagination.Item key={i} active={i === currentPage} onClick={() => {
                onPageChange(i)
            }}>{i}</BootstrapPagination.Item>
        ));
    }

    if (currentPage < numOfPages) {
        items.push(
            <BootstrapPagination.Item key="next" onClick={() => {
                onPageChange(currentPage + 1)
            }}>&raquo;</BootstrapPagination.Item>
        );
    }

    return (
        <BootstrapPagination>{items}</BootstrapPagination>
    );
}

export default Pagination