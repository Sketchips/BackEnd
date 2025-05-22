// Example React component for QRIS payment integration
import React, { useState } from "react";
import axios from "axios";

const QRISPayment = () => {
    const [formData, setFormData] = useState({
        amount: "",
        name: "",
        email: "",
    });
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);
    const [transaction, setTransaction] = useState(null);

    const handleChange = (e) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value,
        });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        setError(null);

        try {
            const response = await axios.post(
                "/api/payment/create-transaction",
                formData
            );

            setTransaction(response.data.data);

            // Option 1: Redirect to Midtrans Snap payment page
            // window.location.href = response.data.data.redirect_url;

            // Option 2: Open QRIS code in a new window
            window.open(response.data.data.redirect_url, "_blank");
        } catch (err) {
            setError(err.response?.data?.message || "Something went wrong");
        } finally {
            setLoading(false);
        }
    };

    const checkStatus = async (id) => {
        try {
            const response = await axios.get(`/api/payment/status/${id}`);
            alert(`Payment Status: ${response.data.data.status}`);
        } catch (err) {
            alert("Failed to check status");
        }
    };

    return (
        <div className="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md">
            <h2 className="text-2xl font-bold mb-6">QRIS Payment</h2>

            {error && (
                <div className="mb-4 p-3 bg-red-100 text-red-700 rounded">
                    {error}
                </div>
            )}

            {transaction ? (
                <div className="mb-6 p-4 border rounded">
                    <h3 className="font-bold mb-2">Transaction Created</h3>
                    <p>Transaction ID: {transaction.transaction_id}</p>
                    <p>Order ID: {transaction.order_id}</p>
                    <div className="mt-4 flex space-x-2">
                        <button
                            onClick={() =>
                                window.open(transaction.redirect_url, "_blank")
                            }
                            className="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                        >
                            Open QRIS Payment
                        </button>
                        <button
                            onClick={() =>
                                checkStatus(transaction.transaction_id)
                            }
                            className="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300"
                        >
                            Check Status
                        </button>
                    </div>
                </div>
            ) : (
                <form onSubmit={handleSubmit}>
                    <div className="mb-4">
                        <label className="block mb-2">Amount (IDR)</label>
                        <input
                            type="number"
                            name="amount"
                            value={formData.amount}
                            onChange={handleChange}
                            required
                            className="w-full p-2 border rounded"
                        />
                    </div>

                    <div className="mb-4">
                        <label className="block mb-2">Name</label>
                        <input
                            type="text"
                            name="name"
                            value={formData.name}
                            onChange={handleChange}
                            required
                            className="w-full p-2 border rounded"
                        />
                    </div>

                    <div className="mb-4">
                        <label className="block mb-2">Email</label>
                        <input
                            type="email"
                            name="email"
                            value={formData.email}
                            onChange={handleChange}
                            required
                            className="w-full p-2 border rounded"
                        />
                    </div>

                    <button
                        type="submit"
                        disabled={loading}
                        className="w-full py-2 px-4 bg-green-500 text-white rounded hover:bg-green-600 disabled:bg-gray-400"
                    >
                        {loading ? "Processing..." : "Pay with QRIS"}
                    </button>
                </form>
            )}
        </div>
    );
};

export default QRISPayment;
