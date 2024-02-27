import {storeRequestQuoteData} from "../../views/network/network";
import {useState} from "react";
import {Modal} from "antd";

const RequestQuoteForm = ({origin, destination, user}) => {
    const params = new URLSearchParams(window.location.search);
    const [isFormSubmitted, setIsFormSubmitted] = useState(false);
    const [formData, setFormData] = useState({
        name: user ? `${user?.first_name} ${user?.last_name}` : null,
        company: user?.company ? `${user?.company?.name}` : null,
        phone: user ? `${user?.phone_number}` : null,
        email: user ? `${user?.email}` : null,
        description: '',
        origin: (origin.city ?? origin.port).trim() +
            `, ${origin.country.name} [${origin.code}]`,
        destination: (destination.city ?? destination.port).trim() +
            `, ${destination.country.name} [${destination.code}]`
    });

    const [isModalOpen, setIsModalOpen] = useState(false);

    const showModal = () => {
        setIsModalOpen(true);
        setIsFormSubmitted(false);
    };

    const handleCancel = () => {
        setIsModalOpen(false);
    };

    const handleFormSubmit = async (e) => {
        e.preventDefault();

        const updatedFormData = {...formData};
        updatedFormData.origin_name = formData.origin;
        updatedFormData.destination_name = formData.destination;
        updatedFormData.route_type = params.get('route_type');
        updatedFormData.booking_company = '-';
        updatedFormData.eta = "-";
        updatedFormData.etd = "-";
        storeRequestQuoteData(updatedFormData)
            .then((res) => {
                if (res.data.status === "success") {
                    setFormData({
                        name: user ? `${user?.first_name} ${user?.last_name}` : null,
                        company: user?.company ? `${user?.company?.name}` : null,
                        phone: user ? `${user?.phone_number}` : null,
                        email: user ? `${user?.email}` : null,
                        description: '',
                        origin: (origin.city ?? origin.port).trim() +
                            `, ${origin.country.name} [${origin.code}]`,
                        destination: (destination.city ?? destination.port).trim() +
                            `, ${destination.country.name} [${destination.code}]`
                    });

                    setIsFormSubmitted(true); // Show the thank you message
                } else {
                    console.error('Form submission failed');
                    alert(res.data.message);
                }
            })
            .catch((error) => {
                console.error('An error occurred', error);
                alert('An error occurred', error);
            })
            .finally(() => {

            });
    };

    const handleGetQuoteClick = () => {
        if (formData.name && formData.email) {
            // If the user is authenticated, show the modal
            showModal();
        } else {
            // If the user is not authenticated, redirect to the login page
            window.location.href = '/login';
        }
    };

    const handleInputChange = (e) => {
        const {name, value} = e.target;
        setFormData((prevData) => ({
            ...prevData,
            [name]: value,
        }));
    };

    return (<>
        <button onClick={handleGetQuoteClick} className="book-button">
            Get Quote
        </button>

        <Modal open={isModalOpen} onCancel={handleCancel} footer={null} width={640}>
            <h2 className="text-xl font-bold mb-4 pb-4 border-b border-gray-300">Quick Request</h2>
            {isFormSubmitted ? ( // If form is submitted, show thank you message
                <div>
                    <h2 className="text-xl font-bold mb-4 pb-4 border-b border-gray-300">Thank You</h2>
                    <p>Your request has been submitted successfully.</p>
                </div>
            ) : (
                <form className="default-form" onSubmit={handleFormSubmit}>
                    <div className="grid grid-cols-2 gap-6">
                        <div className="form-field">
                            <label className="form-label">Origin</label>
                            <input type="text" className="form-input small-input w-full"
                                   name="origin"
                                   value={formData.origin}
                                   onChange={handleInputChange}/>
                        </div>

                        <div className="form-field">
                            <label className="form-label">Destination</label>
                            <input type="text" className="form-input small-input w-full"
                                   name="destination"
                                   value={formData.destination}
                                   onChange={handleInputChange}/>
                        </div>
                        <div className="form-field">
                            <label className="form-label">Full Name</label>
                            <input
                                type="text"
                                className="form-input small-input w-full"
                                name="name"
                                required
                                value={formData.name}
                                onChange={handleInputChange}
                            />
                        </div>

                        <div className="form-field">
                            <label className="form-label">Company</label>
                            <input
                                type="text"
                                className="form-input small-input w-full"
                                name="company"
                                required
                                value={formData.company}
                                onChange={handleInputChange}
                            />
                        </div>

                        <div className="form-field">
                            <label className="form-label">Phone</label>
                            <input
                                type="text"
                                className="form-input small-input w-full"
                                name="phone"
                                required
                                value={formData.phone}
                                onChange={handleInputChange}
                            />
                        </div>

                        <div className="form-field">
                            <label className="form-label">Email</label>
                            <input
                                type="email"
                                className="form-input small-input w-full"
                                name="email"
                                required
                                value={formData.email}
                                onChange={handleInputChange}
                            />
                        </div>
                    </div>

                    <div className="form-field mt-6">
                        <label className="form-label">Description</label>
                        <textarea
                            className="form-input small-input w-full h-[120px] resize-none"
                            name="description"
                            required
                            value={formData.description}
                            onChange={handleInputChange}
                        ></textarea>
                    </div>

                    <div className="form-field mt-6 text-right">
                        <button className="default-button-v2 small-button">
                            <span>Submit</span>
                        </button>
                    </div>
                </form>)}
        </Modal>
    </>)
}

export default RequestQuoteForm;
