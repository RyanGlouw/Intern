// Смена ответственного в AMO

if (firstUser != AMOCRM.sdk.showUserStatus('online'))
{
let select = document.getElementsByClassName('multisuggest users_select-select_one card-fields__fields-block__users-select js-multisuggest js-can-add ')

select[0].onclick = function(e) {e.stopPropagation()}
}

// Получение id текущего пользователя в AMO

AMOCRM.constant('user')["id"]