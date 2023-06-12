(() => {
  'use strict';
  const enterBtn = document.getElementsByClassName('enter-button')[0];
  const regBtn = document.getElementsByClassName('register-button')[0];
  const dangerBox = document.getElementsByClassName('alert-danger')[0];
  const successBox = document.getElementsByClassName('alert-success')[0];
  const usname = document.getElementById('username');
  const psswd = document.getElementById('password');
  let infoflag = false;

  const enableBtn = function () {
    enterBtn.disabled = false;
    regBtn.disabled = false;
  };

  const disableBtn = function () {
    enterBtn.disabled = true;
    regBtn.disabled = true;
  };

  const showСaution = function (text) {
    if (text.length > 0) {
      if (dangerBox.style.display != 'block') {
        dangerBox.style.display = 'block';
      }
      dangerBox.innerHTML = text;
    } else {
      dangerBox.innerHTML = '';
      dangerBox.style.display = 'none';
    }
    if (!infoflag) {
      showRules();
    }
  };

  const showWarning = function (text) {
    if (dangerBox.style.display != 'block') {
      dangerBox.style.display = 'block';
    }
    dangerBox.innerHTML = text;
  };

  const showRules = function () {
    if (!infoflag) {
      successBox.innerHTML =
        'Имя пользователя может содержать только латинские символы и цифры. Длина должна быть не менее 2 символов и не более 20. Пароль может содержать только латинские символы, длина не менее 5.';
      infoflag = true;
    }
  };

  const query = async function (url, name, passwd) {
    disableBtn();
    const config = {
      method: 'POST',
      headers: { 'Content-type': 'application/json;charset=utf-8' },
      redirect: 'follow',
      referrerPolicy: 'no-referrer',
      body: JSON.stringify({ name: name, pass: passwd }),
    };
    try {
      const response = await fetch(url, config);
      enableBtn();
      if (response.redirected) {
        window.location.href = response.url;
      }
      if (response.ok) {
        const result = await response.json();
        if (response.redirected) {
          window.location.href = response.url;
        }
        const userstatus = result.data.userStatus;
        if (userstatus === 'not found' || userstatus === 'not verified') {
          showWarning(
            'Ошибка! Неправильное имя пользователя или пароль. Проверьте введённые данные или зарегистрируйтесь...'
          );
          showRules();
        }
        if (userstatus === 'exist') {
          showWarning(
            'Ошибка! Такое имя уже есть в системе. Выберите другое...'
          );
        }
        if (userstatus === 'registred') {
          usname.value = '';
          psswd.value = '';
          showWarning(
            'Регистрация выполнена успешно!. Для начала работы выполните вход в систему'
          );
        }
      } else {
        enableBtn();
        throw new Error('Ошибка HTTP: ' + response.status);
      }
    } catch (error) {
      console.log(error);
    }
  };

  const validateName = (text) => {
    const regexp = /^[a-zA-Z0-9]{2,20}$/u;
    return regexp.test(text);
  };

  const validatePsswd = (text) => {
    const regexp = /^[a-zA-Z][^0-9]{5,}$/u;
    return regexp.test(text);
  };

  const change = function (e) {
    let valid = true;
    let message = '';
    if (!validateName(usname.value)) {
      usname.style.borderColor = 'red';
      valid = false;
      message = 'Недопустимое имя пользователя!<br>';
    } else {
      usname.style.borderColor = 'rgba(0, 0, 0, 0.15)';
    }
    if (!validatePsswd(psswd.value)) {
      valid = false;
      psswd.style.borderColor = 'red';
      message += 'Недопустимый пароль!<br>';
    } else {
      psswd.style.borderColor = 'rgba(0, 0, 0, 0.15)';
    }
    if (valid) {
      enableBtn();
    } else {
      disableBtn();
    }
    showСaution(message);
  };

  const registerUser = function (e) {
    if (validateName(usname.value) && validatePsswd(psswd.value)) {
      query('register', usname.value, psswd.value);
    }
  };

  const verifyUser = function (e) {
    if (validateName(usname.value) && validatePsswd(psswd.value)) {
      console.log(validateName(usname.value), validatePsswd(psswd.value));
      e.stopPropagation();
      e.preventDefault();
      query('auth', usname.value, psswd.value);
    }
  };

  enterBtn.addEventListener('click', verifyUser);
  regBtn.addEventListener('click', registerUser);
  usname.addEventListener('input', change);
  psswd.addEventListener('input', change);
  disableBtn();
})();
