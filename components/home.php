<head>
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            /* Corrected here */
            height: 100vh;
        }

        .intro {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: max-content;
            top: 30%;
            left: 40%;
            height: 200px;
            position: fixed;
            z-index: 10;
            /* Changed here */
            border-radius: 15px;
            padding: 10px;
            padding-bottom: 20px;
            /* border: 3px solid red; */
            box-shadow: 0 0 4px black, 1px 1px 10px red, -1px -1px 10px blue;
            animation: intro 2s 0s ease-in infinite;
        }

        @keyframes intro {
            50% {
                box-shadow: 0 0 4px rgb(17, 17, 17), 1px 1px 10px blue, -1px -1px 10px red;
            }

            100% {
                box-shadow: 0 0 4px rgb(17, 17, 17), 1px 1px 10px red, -1px -1px 10px blue;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="intro">
            <img src="../images/logo.png" width="400" alt="my-logo">
            <p class="headings">Welcome to our online appointment booking site.</p>
            <p class="headings">Here you can book your appointment with your preferred doctor just in few clicks.</p>
        </div>
    </div>
</body>

</html>