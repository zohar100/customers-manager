import { UI } from '../UI.js';
import { formValidation } from './formValidation.js';

const ui = new UI();

function getCheckedCheckBoxes (inputName) {
    const result = $(`input[name="${inputName}"]:checked`);
    const arr = [];
    if(result.length > 0) {
        result.each((i) => {
            arr.push($(result[i]).val());
        })
        return arr;
    }else {
        return '';
    }
}

export function getFormValuesAndValidate(inputs, rules) {
    const $inputs = inputs; 

    // Object for storing the values of the form
    const values = {};
    let isCheckboxes = false;
    let checkboxName = '';

    // Get values from the form and pass to values
    $inputs.each(function() {
        if(this.type==='checkbox'){
            isCheckboxes = true;
            checkboxName = this.name;
        }
        else if(this.name === 'gender') {
            values[this.name] = $('input[name=gender]:checked', '#customerForm').val();
        }else{
            console.log(values[this.name]);
            // Store name as key and values
            values[this.name] = $(this).val();
        }
    });
    if(isCheckboxes) {
        values[checkboxName] = getCheckedCheckBoxes(checkboxName);
    }

    let valid = true;
    if(rules) {
        // Check validation
        for (let key in values) {
            if(!formValidation(values[key], rules[key])){
                console.log(values, rules[key]);
                valid = false;
                ui.popUpMessage('fail', `${key} is not valid`)
            }
        }
    
        if(valid) {
            //Reset Inputs
            $inputs.each(function() {
                $(this).val('');
            });
        }
        return [values, valid];
    }else return values;
    
}