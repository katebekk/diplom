document.getElementById('plus').addEventListener('click', function (event) {
    document.getElementById('plus').parentNode.before(createQuestion());
});
function createQuestion() {
    let questionNumEl = document.getElementById('value')
    let num = questionNumEl.value + 1
    questionNumEl.value = num

    let divGroup = document.createElement('div');
    divGroup.className = 'col-md-8 order-md-1';
    let label = document.createElement('label');
    label.className = 'dis';
    label.append ('Вопрос');
    let input = document.createElement('input');
    input.type = 'text';
    input.className = 'value input';
    input.name = 'questions[]';
    input.required = true;
    let labelAnswer = document.createElement('label');
    labelAnswer.className = 'dis';
    labelAnswer.append ('Ответы:');

    divGroup.appendChild(label);
    divGroup.appendChild(input);
    divGroup.appendChild(labelAnswer);
    for (var i = 0; i <= 3; i++) {
        let divGroupTwo = document.createElement('div');
        divGroupTwo.className = 'row';

        let divGroupTwoFirst= document.createElement('div');
        divGroupTwoFirst.className = 'col-sm';
        let inputTwoOne = document.createElement('input');
        inputTwoOne.type = 'text';
        inputTwoOne.className = 'value input inline';
        inputTwoOne.name = 'answers[]';
        inputTwoOne.required = true;
        divGroupTwoFirst.appendChild(inputTwoOne)

        let divGroupTwoSecond = document.createElement('div');
        divGroupTwoSecond.className = 'col-sm';
        let inputTwoSecond = document.createElement('input');
        inputTwoSecond.type = 'checkbox';
        inputTwoSecond.className = 'value input inline';
        inputTwoSecond.name = 'isRights[]';
        inputTwoSecond.checked = true;
        inputTwoSecond.value = 'answer-' + num + '-' + i;
        divGroupTwoSecond.appendChild(inputTwoSecond)
        divGroupTwo.appendChild(divGroupTwoFirst)
        divGroupTwo.appendChild(divGroupTwoSecond)
        divGroup.appendChild(divGroupTwo);
    }
    return divGroup;
}
