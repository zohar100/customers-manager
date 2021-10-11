import { Api } from '../Api.js';
import { UI } from '../UI.js';
import { getFormValuesAndValidate } from '../utilities/getFormValuesAndValidate.js';

const api = new Api();
const ui = new UI();

function getCustomers () {
    ui.setLoading(true);
    const response = api.get('/api/customers/read.php');
    response.then(res => {
        if(res) {
            ui.loadTableBody(res, $('#customers'));
            ui.setLoading(false);
        }  
    })
}

$(document).ready(() => {
    getCustomers();

    // Delete Customers
    $('table').click((e) => {
        if(e.target.classList.contains('delete-btn')){
            const response = api.delete('/api/customers/delete.php', JSON.stringify({
                id: e.target.dataset.id
            }));
            response.then((data) => {
                if(data.status){
                    ui.popUpMessage('success', data.message);
                    getCustomers();
                }else {
                    ui.popUpMessage('fail', data.message);
                }
            });
        };

    })

    // Search Customers
    $('#searchForm').submit((e) => {
        e.preventDefault();
        
        const values = getFormValuesAndValidate($('#searchForm :input'));

        ui.setLoading(true);
        const response = api.get('/api/customers/search.php?search=' + values.search);
        response.then(res => {
            if(res) {
                ui.loadTableBody(res, $('#customers'));
                ui.setLoading(false);
            }  
        })
    })
});