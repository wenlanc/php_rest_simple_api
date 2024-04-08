## WeStore API List ##

# Login the User
  url: `https://wesotre.ge/api/v1/login`
  method: POST
  input parameter:
    `idnumber`, `password`
  return:
    `id`, `token`

  example:
    Input
      idnumber: '405332670'
      password: 'Data2004@@'

    Output
      {
        `id`: 1
        `token`: 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCIsImlzcyI6Imp3dC5sb2NhbCIsImF1ZCI6InRva2VuQHdlc3RvcmUuZ2UifQ.eyJpZCI6IjEiLCJpZG51bWJlciI6IjQwNTMzMjY3MCIsImlzcyI6Imp3dC5sb2NhbCIsImF1ZCI6InRva2VuQHdlc3RvcmUuZ2UiLCJleHAiOjE3MTI1ODkzMTN9.q8RvbOWCGeb26HqQT1LyKG0qWl0tHKMWX2_mWaEFLjc'
      }


# Register the User
  url: `https://wesotre.ge/api/v1/register`
  method: POST
  input parameter:
    `status`, `company`, `email`, `phone`, `idnumber`, `password`(crypted using PASSWORD_BCRYPT), `finances`, `edit_product_name` 
  return:
    `id`,`token`

  example:
    Input
      `status`: 'აქტიური'
      `idnumber`: '405332670'
      `password`: '$10$YMw2ezJAHOYLHJR7ilwcjOl.nz7GvOMPYXCd92.8wfS25uE5S2enm'
      ....

    Output
      {
        `id`: 20
        `token`: 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCIsImlzcyI6Imp3dC5sb2NhbCIsImF1ZCI6InRva2VuQHdlc3RvcmUuZ2UifQ.eyJpZCI6IjEiLCJpZG51bWJlciI6IjQwNTMzMjY3MCIsImlzcyI6Imp3dC5sb2NhbCIsImF1ZCI6InRva2VuQHdlc3RvcmUuZ2UiLCJleHAiOjE3MTI1ODkzMTN9.q8RvbOWCGeb26HqQT1LyKG0qWl0tHKMWX2_mWaEFLjc'
      }


# Get the list of cities
  url: `https://wesotre.ge/api/v1/cities`
  method: GET
  return:
    list of cities

  example:
    Output
      {
        "1": {
            "id": "1",
            "name_en": "Agara",
            "name": "აგარა"
        },
        "2": {
            "id": "2",
            "name_en": "Agaraki",
            "name": "აგარაკი"
        },
        "3": {
            "id": "3",
            "name_en": "Adigeni",
            "name": "ადიგენი"
        },

        ...
        ...
      }


# Get the list of shipping types
  url: `https://wesotre.ge/api/v1/shippingtypes`
  method: GET
  return:
    list of shipping types

  example:
    Output
      {
        {
          "id": "1",
          "name": "სტანდარტული"
        },
        {
          "id": "2",
          "name": "სწრაფი"
        },
        {
          "id": "3",
          "name": "იმავე დღეს"
        }
      }


# Get the list of products by user token
  url: `https://wesotre.ge/api/v1/products`
  method: GET
  headers: {
    Authorization: "Bearer <insert_your_token_here>"
  }
  input parameter:
    `user_id`
  return:
    list of products

  example:
    Url:  `https://wesotre.ge/api/v1/products?user_id=1`
    headers: {
      Authorization: "Bearer <insert_your_token_here>"
    }
    Input
      `user_id`: 1

    Output
      {
        {
          "number": "722208569881",
          "name": "გასაღების სეიფი G1 (k001)"
        },
        {
          "number": "722208569973",
          "name": "მინი გასაღების სეიფი G10 (k009)"
        },
        {
          "number": "722208570436",
          "name": "4-in-1 USB C/USB A HUB Docking Station with USB 3.0 and 2.0"
        },
        ... ...
      }


# Get the list of product quantities by the user
  url: `https://wesotre.ge/api/v1/quantities`
  method: GET
  headers: {
    Authorization: "Bearer <insert_your_token_here>"
  }
  input parameter:
    `user_id`
  return:
    list of shipping types

  example:
    Url: `https://wesotre.ge/api/v1/quantities?user_id=1`
    Input
      `user_id`: 1

    Output
      {
        {
          "number": "722208569881",
          "qty": "523"
        },
        {
          "number": "722208569973",
          "qty": "50"
        },
        {
          "number": "722208570436",
          "qty": "5"
        },
        ... ...
      }


# Add Orders
  url: `https://wesotre.ge/api/v1/orders`
  method: POST
  headers: {
    Authorization: "Bearer <insert_your_token_here>"
  }
  input parameter:
    `user_id`, `fullname`, `city`, `address`, `phone`, `phone2`, `amount`, `shipping_type`, `shipping_id`, 
    `delivery_channel`, `weight`, `comment`, `numbers`(must be array), `names`(must be array), `quantities`(must be array)
  return:
    "Order added successfully!"

  example:
    Input
      {
        `id`: 1
        `fullname`: 'fullname'
        `city`: 'city address'
        ....
      }

    Output
      ["success" => "Order added successfully!"]