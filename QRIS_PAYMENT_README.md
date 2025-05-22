# QRIS Payment Integration with Midtrans

This project integrates QRIS payment using Midtrans Snap in a Laravel backend.

## Setup Instructions

### 1. Environment Configuration

Update your `.env` file with the following Midtrans configuration:

```
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_SERVER_KEY=SB-Mid-server-YOUR_SERVER_KEY
MIDTRANS_CLIENT_KEY=SB-Mid-client-YOUR_CLIENT_KEY
```

For production:

```
MIDTRANS_IS_PRODUCTION=true
MIDTRANS_SERVER_KEY=Mid-server-YOUR_PRODUCTION_SERVER_KEY
MIDTRANS_CLIENT_KEY=Mid-client-YOUR_PRODUCTION_CLIENT_KEY
```

You can get your Sandbox API keys from the Midtrans Dashboard.

### 2. Run Migrations

Execute the following command to create the transactions table:

```bash
php artisan migrate
```

### 3. API Endpoints

The following endpoints are available:

-   **POST /api/payment/create-transaction**

    -   Creates a new QRIS payment transaction
    -   Payload:
        ```json
        {
            "amount": 50000,
            "name": "Customer Name",
            "email": "customer@example.com"
        }
        ```
    -   Response:
        ```json
        {
            "success": true,
            "data": {
                "transaction_id": 1,
                "order_id": "ORDER-1621234567-5f9a8b7c6d",
                "token": "66e4fa55-fdac-4ef9-91b5-733b97d1b862",
                "redirect_url": "https://app.sandbox.midtrans.com/snap/v2/vtweb/66e4fa55-fdac-4ef9-91b5-733b97d1b862"
            }
        }
        ```

-   **POST /api/payment/notification**

    -   Webhook URL for Midtrans payment notifications
    -   This should be configured in your Midtrans dashboard

-   **GET /api/payment/status/{id}**
    -   Gets the status of a transaction by ID
    -   Response:
        ```json
        {
            "success": true,
            "data": {
                "id": 1,
                "order_id": "ORDER-1621234567-5f9a8b7c6d",
                "amount": "50000.00",
                "status": "success",
                "payment_type": "qris",
                "transaction_time": "2023-05-15 12:30:45"
            }
        }
        ```

### 4. Frontend Integration

Here's an example of how to integrate with a React frontend:

```jsx
import axios from "axios";

// Create transaction and get QRIS payment URL
const createTransaction = async (paymentData) => {
    try {
        const response = await axios.post("/api/payment/create-transaction", {
            amount: paymentData.amount,
            name: paymentData.name,
            email: paymentData.email,
        });

        // Get the redirect URL to QRIS payment page
        const redirectUrl = response.data.data.redirect_url;

        // Option 1: Redirect to payment page
        window.location.href = redirectUrl;

        // Option 2: Open in new window
        // window.open(redirectUrl, '_blank');

        return response.data;
    } catch (error) {
        console.error("Error creating transaction:", error);
        throw error;
    }
};

// Check transaction status
const checkTransactionStatus = async (transactionId) => {
    try {
        const response = await axios.get(
            `/api/payment/status/${transactionId}`
        );
        return response.data;
    } catch (error) {
        console.error("Error checking transaction status:", error);
        throw error;
    }
};
```

### 5. Production Considerations

-   Configure your webhook URL in the Midtrans dashboard to receive payment notifications
-   Make sure your server can receive POST requests from Midtrans for the notification handler
-   Use HTTPS for production deployments
-   Remember to switch to production keys when going live

## Testing

You can test the QRIS payment with Midtrans Sandbox:

1. Create a transaction using the API
2. Open the QRIS payment page
3. In the sandbox environment, you can simulate payments using the Midtrans sandbox simulator

## Troubleshooting

-   If you encounter any issues with the Midtrans integration, check the Laravel logs
-   Ensure your server can receive webhook notifications from Midtrans
-   Verify your Midtrans API keys are correctly set in the `.env` file
