import React, {useContext, useState, useEffect} from "react";
import SchoolList from '../components/school-list/SchoolList'
import Pagination from '../components/pagination/Pagination'

import ListContext from "../context/ListContext";

function List() {
    const listContext = useContext(ListContext);
    const [schools, setSchools] = useState([]);
    const [currentPage, setCurrentPage] = useState(listContext.page);
    const [totalPages, setTotalPages] = useState(0);

    useEffect(() => {
        fetch('/schools/?page=' + currentPage + '&pageSize=' + listContext.pageSize).then(res => res.json())
            .then((data) => {
                setSchools(data.items);
                setTotalPages(data.page_information.total);
            }).catch((e) => {
                console.log(e)
            });
    }, [currentPage]);

    return (
        <div>
            <SchoolList schools={schools}/>
            <Pagination current={currentPage} total={totalPages} onPageChange={(page) => {setCurrentPage(page)}}/>
        </div>
    );
}

export default List