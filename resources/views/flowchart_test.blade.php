{{-- 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recreated Flowchart with Tooltips</title>
    <script type="module">
        import mermaid from 'https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.esm.min.mjs';
        mermaid.initialize({
            startOnLoad: true
        });
    </script>
    <style>
        /* Tooltip styling */
        .node rect {
            transition: fill 0.3s ease;
        }

        .node:hover rect {
            fill: #c6e2ff;
            /* Change color on hover */
        }
    </style>
</head>

<body>

    <h1>Flowchart Example</h1>

    <!-- Mermaid flowchart definition -->
    <div class="container">
        <div class="mermaid">
            graph TD
            A[Dataset]:::hoverable --> B[Training dataset]
            A --> C[Test dataset]
            B --> D[Model]
            C --> E[Evaluate]
            D --> E
            E -->|Error acceptable?| F{Error acceptable?}
            F -->|Yes| G[Forecast]
            F -->|No| H[Retrain Model]
            H --> D
            click A "https://example.com/dataset" "This is the dataset"
            click B "https://example.com/training" "This is the training dataset"
            click C "https://example.com/test" "This is the test dataset"
            click D "https://example.com/model" "This is the model"
            click E "https://example.com/evaluate" "This is the evaluation step"
            click F "https://example.com/decision" "This is the decision point"
            click G "https://example.com/forecast" "This is the forecasting step"
            click H "https://example.com/retrain" "This is the retraining step"
        </div>
    </div>

</body>

</html> --}}


<html>

<body>
    Here is one mermaid diagram:
    <pre class="mermaid">
            graph TD
            A[Client] --> B[Load Balancer]
            B --> C[Server1]
            B --> D[Server2]
    </pre>

    And here is another:
    <pre class="mermaid">
            graph TD
            A[Client] -->|tcp_123| B
            B(Load Balancer)
            B -->|tcp_456| C[Server1]
            B -->|tcp_456| D[Server2]
    </pre>

    <script type="module">
        import mermaid from 'https://cdn.jsdelivr.net/npm/mermaid@11/dist/mermaid.esm.min.mjs';
        mermaid.initialize({
            startOnLoad: true
        });
    </script>
</body>

</html>
