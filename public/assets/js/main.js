(() => {
  const container = document.getElementsByClassName('info')[0];
  const buttons = document.getElementsByClassName('controlbtn');

  const runQuery = async function (uri) {
    const config = {
      method: 'GET',
      url: uri,
    };
    try {
      const response = await axios(config);
      if (response.status === 200) {
        const result = await response.data;
        if (uri === 'users') {
          let content = '';
          for (let item of result.data) {
            let id = JSON.stringify(item.id);
            let username = JSON.stringify(item.username);
            let email = JSON.stringify(item.email);
            content += `${id.padEnd(2)} | ${username.padEnd(10)} | ${email.padEnd(25)} | ${item.created.date}\r\n`;
          }
          container.value = content;
        }
        if (uri === 'instock') {
          container.value = JSON.stringify(result.data);
        }
      }
    } catch (error) {
      console.log(error);
    }
  };

  const firstButton = function (event) {
    runQuery('users');
  };
  const secondButton = function (event) {
    runQuery('user/admin');
  };
  const thirdButton = function (event) {
    runQuery('instock');
  };

  buttons[0].addEventListener('click', firstButton);
  buttons[1].addEventListener('click', thirdButton);
})();
