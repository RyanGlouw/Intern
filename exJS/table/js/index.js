
const managers = {
  '7270678': [],
'7292140': []
}

let table = document.querySelector('#table');

let row = document.createElement('tr')
row.innerHTML = `<th></th>
  <th>Сделки</th>
  <th>Контакты</th>
  <th>Компании</th>`
  document.querySelector('#table').appendChild(row)

for(let manager in managers)
{
  
  let row = document.createElement('tr')
  let check = '<td><input type="checkbox" class = "check"</td>'
  for(let i = 0; i < 3; i++)
  {
  row.innerHTML = `<td>${manager}</td>
  ${check}
  ${check}
  ${check}
  `
  }
  document.querySelector('#table').appendChild(row)
}
