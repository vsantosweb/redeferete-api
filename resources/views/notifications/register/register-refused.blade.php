<div>
    <style>
        .content {
            margin: auto;
            max-width: 700px;
            width: 100%;
        }

        .header,
        .footer{
            background: #f1f1f1;
            padding: 1.5em;
        }

        .body {
            padding: 1.5em;

        }

        div {
            font-family: Arial, Helvetica, sans-serif;
        }

        .action-button {
            font-family: "Montserrat", Sans-serif;
            font-size: 16px;
            font-weight: 500;
            background-color: #c42124;
            color: #fff;
            outline: none;
            box-shadow: none;
            border: none;
            border-radius: 10px 10px 10px 10px;
            padding: 16px 15px 16px 15px;
            text-align: center;
            margin: auto;
            cursor: pointer;
            margin: 1em 0;
            display: inline-block;
            text-decoration: none;
        }
        
    </style>
    <div class="content">
        <div class="header">
            <img width="155"
                src="https://cdn-fjimc.nitrocdn.com/JSzfuJQvhIRmYNPgwONoFDikiekKjiQE/assets/static/optimized/rev-a45b43e/wp-content/uploads/2022/09/logo_redefrete-1.png" />
        </div>
        <div class="body">
            <p>Olá,</p>
            <p>
                Recebemos seu cadastro na Redefrete, mas infelizmente seu endereço não atende nossa demanda no momento.
            </p>
        </div>
        <div class="footer">
            <span>© {{ date("Y") }} {{env('APP_NAME')}}. All rights reserved.</span>
        </div>
    </div>
</div>