<!-- 
 Documentation Swagger UI
https://swagger.io/docs/open-source-tools/swagger-ui/customization/custom-layout/?sbsearch=layout
 -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API V3 Documentation - Swagger UI</title>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/swagger-ui-dist@5.17.14/swagger-ui.css" />
    <style>
        html {
            box-sizing: border-box;
            overflow: -moz-scrollbars-vertical;
            overflow-y: scroll;
        }
        *, *:before, *:after {
            box-sizing: inherit;
        }
        body {
            margin:0;
            background: #fafafa;
        }
    </style>
</head>
<body>
    <div id="swagger-ui"></div>
    <script src="https://unpkg.com/swagger-ui-dist@5.17.14/swagger-ui-bundle.js"></script>
    <script src="https://unpkg.com/swagger-ui-dist@5.17.14/swagger-ui-standalone-preset.js"></script>
    <script>
        window.onload = function() {
            const ui = SwaggerUIBundle({
                url: "./swagger.json",
                dom_id: '#swagger-ui',
                deepLinking: true,
                presets: [
                    SwaggerUIBundle.presets.apis,
                    SwaggerUIStandalonePreset
                ],
                plugins: [
                    SwaggerUIBundle.plugins.DownloadUrl
                ],
                layout: "StandaloneLayout",
                onComplete: function() {
                    console.log("Swagger UI loaded successfully");
                },
                onFailure: function(data) {
                    console.error("Failed to load Swagger UI:", data);
                    document.getElementById('swagger-ui').innerHTML = 
                        '<div style="padding: 20px; color: red;">' +
                        '<h2>Erreur lors du chargement de la documentation</h2>' +
                        '<p>Impossible de charger le fichier swagger.json. Vérifiez la console pour plus de détails.</p>' +
                        '<p><a href="./swagger.json" target="_blank">Voir le JSON directement</a></p>' +
                        '</div>';
                }
            });
        };
    </script>
</body>
</html>

