import { Api } from '../Api.js';
import { UI } from '../UI.js';
import { getFormValuesAndValidate } from '../utilities/getFormValuesAndValidate.js';

const api = new Api();
const ui = new UI();

//Form rules
const rules = {
    name: {
        required: true
    },
    type: {
        maxLength: 1,
    },
    email: {
        isEmail: true
    },
    phone: {
        minLength: 10,
        maxLength:10
    },
    address: {
        required: true
    },
    gender: {
        maxLength: 1
    },
    fav_products: {
        minLength: 1
    }
}

$(document).ready(function () {
    ui.setLoading(true);
    const productsResponse = api.get('/api/products/read.php');
    productsResponse.then(val => {
        if(val.data) {
            ui.loadFormProducts(val.data, $('#productsForm'));
            ui.setLoading(false);
        }    
    })

    ui.setLoading(true);
    const typesResponse = api.get('/api/types/read.php');
    typesResponse.then(val => {
        if(val.data) {
            ui.loadFormTypes(val.data, $('#typesForm'));
            ui.setLoading(false);
        }    
    })

    //Add Customer
    $('#customerForm').submit((e) => {
        e.preventDefault();

        const [values, valid] = getFormValuesAndValidate ($('#customerForm :input'), rules);

        if(valid){
            // Api request
            ui.setLoading(true);
            const response = api.post('/api/customers/create.php', JSON.stringify(values));
            response.then(data => {
                if(data.status) {
                    ui.setLoading(false);
                    ui.popUpMessage('success', data.message)
                }else{
                    ui.setLoading(false);
                    ui.popUpMessage('fail', data.message)
                }
            })
        }
    });
})