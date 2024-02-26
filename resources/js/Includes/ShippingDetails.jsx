import React, {useEffect} from "react";
import {currencyFormatter} from "../../views/helpers/helpers";
import {Accordion, AccordionBody, AccordionHeader, AccordionItem} from "react-headless-accordion";
import {usePage} from "@inertiajs/react";
// import { storeBookingPriceBreakDownDetailsInSession } from "../../views/network/network";
import ShippingDetailsRow from "@/Includes/ShippingDetailsRow";

const ShippingDetails = ({setTotalAmount, setTrackOne, setCircleOne, setTrackThree, setCircleFour, price_amount, price_details, uid, company_id, updatePriceBreakDown, filterChargeTypes, hot_deals}) => {
    const {constants} = usePage().props;
    const params = new URLSearchParams(window.location.search);
    let charges = [];

    const getDefaultCheck = (charge_name) => {
        let haystack = charge_name.toLowerCase();
        let result = true;
        if(haystack.includes('pickup')) {
            result = filterChargeTypes.pickup;
        } else if(haystack.includes('origin')) {
            result = filterChargeTypes.origin;
        } else if(haystack.includes('destination')) {
            result = filterChargeTypes.destination;
        } else if(haystack.includes('delivery')) {
            result = filterChargeTypes.delivery;
        }
        return result;
    }
	
	/**
    useEffect(() => {
        if (company_id === constants.CMA_COMPANY_ID || hot_deals) {
            setTotalAmount(price_amount);
        }
    }, [filterChargeTypes]);
	/**/

    if ((price_amount && constants.IGNORED_COMPANIES.includes(company_id)) || hot_deals) {
        charges.push({
            'heading': 'Pickup Charges',
            data: [{name: "Pickup Charges", amount: 0, message: 'Amount will be shared later'}]
        });
    }

    if (company_id === constants.CMA_COMPANY_ID) {
		/**
        if (price_details?.charges) {
            charges.push({'heading': 'Per Equipment', data: price_details?.charges});
        }
        if (price_details?.extra) {
            charges.push({'heading': 'Extras', data: price_details?.extra});
        }
		/**/
		
		/**/
		let org_chargs = 0;
		let base_chargs = 0;
		let dest_chargs = 0;
		
		price_details?.charges?.forEach((chargex, index) => {
			//alert(JSON.stringify(chargex.charge_name)+" | "+JSON.stringify(chargex.amount)+" | "+JSON.stringify(chargex.included));	

			if(chargex.charge_name.toLowerCase().includes('origin')){
				if(chargex.amount !== null){
					org_chargs += chargex.amount;
				}
			}
			else if(chargex.charge_name.toLowerCase().includes('destination')){
				if(chargex.amount !== null){
					dest_chargs += chargex.amount;
				}
			}
			else{
				if(chargex.amount !== null){
					base_chargs += chargex.amount;
				}
			}
			
        });
		
		charges.push({
            'heading': 'Origin Charges', data: [{
                name: "Origin Charges", amount: org_chargs
            }]
        });

        charges.push({
            'heading': 'Freight Charges', data: [{
                name: "BASIC OCEAN FREIGHT", amount: base_chargs + 100
            }]
        });

        charges.push({
            'heading': 'Destination Charges', data: [{
                name: "Destination Charges", amount: dest_chargs
            }]
        });
		
		/**/
    } else if (company_id === constants.MAERSK_COMPANY_ID) {
        if (price_details?.origin_charges_total_usd) {
            charges.push({
                'heading': 'Origin Charges',
                data: [{name: 'Origin Charges', amount: price_details?.origin_charges_total_usd}]
            });
        }
        if (price_details?.freight_charges_total_usd) {
            charges.push({
                'heading': 'Freight Charges',
                data: [{
                    name: "BASIC OCEAN FREIGHT",
                    amount: parseFloat(price_details?.freight_charges_total_usd) + 100
                }]
            });
        }
        if (price_details?.destination_charges_total_usd) {
            charges.push({
                'heading': 'Destination Charges',
                data: [{name: "Destination Charges", amount: price_details?.destination_charges_total_usd}]
            });
        }
    } else if (company_id === constants.HAPAG_COMPANY_ID) {
        let data = {
            'origin_charges': 0, 'freight_charges': price_amount, 'destination_charges': 0,
        };

        price_details?.charges
            .map(charge => {
                if ("Freight Surcharges" === charge.ChargeType) {
                    data.freight_charges += charge.Amount;
                } else if ("Export Surcharges" === charge.ChargeType) {
                    data.origin_charges += charge.Amount;
                } else if ("Import Surcharges" === charge.ChargeType) {
                    data.destination_charges += charge.Amount;
                }
            });

        // Set Origin Charges
        charges.push({
            'heading': 'Origin Charges', data: [{name: 'Origin Charges', amount: parseFloat(data.origin_charges)}]
        });

        // Set Freight Charges
        charges.push({
            'heading': 'Freight Charges', data: [{
                name: "BASIC OCEAN FREIGHT", amount: parseFloat(data.freight_charges) + 100
            }]
        });

        // Set Destination Charges
        charges.push({
            'heading': 'Destination Charges',
            data: [{name: "Destination Charges", amount: parseFloat(data.destination_charges)}]
        });
    } else if (company_id === constants.MSC_COMPANY_ID) {
		
		//alert(JSON.stringify(price_details));
		
        charges.push({
            'heading': 'Origin Charges', data: [{
                name: "Origin Charges", amount: price_details.origin_charges
            }]
        });

        charges.push({
            'heading': 'Freight Charges', data: [{
                name: "BASIC OCEAN FREIGHT", amount: price_details.freight_charges + 100
            }]
        });

        charges.push({
            'heading': 'Destination Charges', data: [{
                name: "Destination Charges", amount: price_details.destination_charges
            }]
        });

    } else {
        if (price_details?.pickup_charges) {
            charges.push({
                'heading': 'Pickup Charges', data: [{name: "Pickup Charges", amount: price_details?.pickup_charges}]
            });
        }
        if (price_details?.origin_charges || price_details?.origin_charges_included) {
            charges.push({
                'heading': 'Origin Charges', data: [{
                    name: "Origin Charges",
                    included: price_details?.origin_charges_included,
                    amount: price_details?.origin_charges
                }]
            });
        }
        if (price_details?.freight_charges) {
            let chargeName = parseInt(params.get('route_type')) === constants.ROUTE_TYPE_LAND ? "BASIC LAND FREIGHT" : "BASIC OCEAN FREIGHT";
            charges.push({
                'heading': 'Freight Charges', data: [{name: chargeName, amount: price_details?.freight_charges}]
            });
        }
        if (price_details?.destination_charges || price_details?.destination_charges_included) {
            charges.push({
                'heading': 'Destination Charges', data: [{
                    name: "Destination Charges",
                    included: price_details?.destination_charges_included,
                    amount: price_details?.destination_charges
                }]
            });
        }
        if (price_details?.delivery_charges) {
            charges.push({
                'heading': 'Delivery Charges',
                data: [{name: "Delivery Charges", amount: price_details?.delivery_charges}]
            });
        }
    }

    if ((price_amount && constants.IGNORED_COMPANIES.includes(company_id)) || hot_deals) {
        charges.push({
            'heading': 'Delivery Charges',
            data: [{name: "Delivery Charges", amount: 0, message: 'Amount will be shared later'}]
        });
    }
    
    return ((charges.length > 0) && <Accordion className="product-price-breakdown">
        <AccordionItem>
        <AccordionHeader className={`${parseInt(params.get('route_type')) === constants.ROUTE_TYPE_LAND ? 'land-accordion-head' : 'accordion-head'}`} />

            <AccordionBody>
                <div className="accordion-body">
                    <h2 className="title">Price Breakdown</h2>
                    <table className="price-breakdown-table">
                        <tbody>
                        {charges.length > 0 && charges.map((chargeType, index) => {
                            if (chargeType.data.length) {
                                return (<React.Fragment key={`${company_id}-${index}`}>
                                    <tr>
                                        <th colSpan={2}>{chargeType.heading}</th>
                                    </tr>
                                    {chargeType.data.map((charge, i) => {
                                        if (company_id === constants.CMA_COMPANY_ID) {
											/**
                                            return <tr
                                                key={`shipping_details_charges_${uid}-${company_id}-${index}-${i}`}>
                                                <td>{charge.charge_code} - {charge.charge_name}</td>
                                                <td className="text-right">{charge.hasOwnProperty('included') && charge.included === true && !charge.charge_name.includes('FREIGHT') ? 'Included in Ocean Freight' : currencyFormatter(charge.amount)}</td>
                                            </tr>
											/**/
											
											/**/
											return <ShippingDetailsRow charge={charge}
                                                                       key={`${uid}-${company_id}-${index}-${i}`}
                                                                       name={`${uid}-${company_id}-${index}-${i}`}
                                                                       setTotalAmount={setTotalAmount}
																	   setTrackOne={setTrackOne}
																	   setCircleOne={setCircleOne}
																	   setTrackThree={setTrackThree}
																	   setCircleFour={setCircleFour}
                                                                       updatePriceBreakDown={updatePriceBreakDown}
                                                                       filterChargeTypes={filterChargeTypes}
                                                                       defaultChecked={getDefaultCheck(charge.name)}/>
											/**/
											
                                        } else if (company_id === constants.MAERSK_COMPANY_ID) {
                                            return <ShippingDetailsRow charge={charge}
                                                                       key={`${uid}-${company_id}-${index}-${i}`}
                                                                       name={`${uid}-${company_id}-${index}-${i}`}
                                                                       setTotalAmount={setTotalAmount}
																	   setTrackOne={setTrackOne}
																	   setCircleOne={setCircleOne}
																	   setTrackThree={setTrackThree}
																	   setCircleFour={setCircleFour}
                                                                       updatePriceBreakDown={updatePriceBreakDown}
                                                                       filterChargeTypes={filterChargeTypes}
                                                                       defaultChecked={getDefaultCheck(charge.name)}/>
                                        } else if (company_id === constants.HAPAG_COMPANY_ID) {
                                            return <ShippingDetailsRow charge={charge}
                                                                       key={`${uid}-${company_id}-${index}-${i}`}
                                                                       name={`${uid}-${company_id}-${index}-${i}`}
                                                                       setTotalAmount={setTotalAmount}
																	   setTrackOne={setTrackOne}
																	   setCircleOne={setCircleOne}
																	   setTrackThree={setTrackThree}
																	   setCircleFour={setCircleFour}
                                                                       updatePriceBreakDown={updatePriceBreakDown}
                                                                       defaultChecked={getDefaultCheck(charge.name)}/>
                                        } else if (company_id === constants.MSC_COMPANY_ID) {
                                            return <ShippingDetailsRow charge={charge}
                                                                       key={`${uid}-${company_id}-${index}-${i}`}
                                                                       name={`${uid}-${company_id}-${index}-${i}`}
                                                                       setTotalAmount={setTotalAmount}
																	   setTrackOne={setTrackOne}
																	   setCircleOne={setCircleOne}
																	   setTrackThree={setTrackThree}
																	   setCircleFour={setCircleFour}
                                                                       updatePriceBreakDown={updatePriceBreakDown}
                                                                       defaultChecked={getDefaultCheck(charge.name)}/>
                                        } else {
                                            return <ShippingDetailsRow charge={charge}
                                                                       key={`${uid}-${company_id}-${index}-${i}`}
                                                                       name={`${uid}-${company_id}-${index}-${i}`}
                                                                       setTotalAmount={setTotalAmount}
																	   setTrackOne={setTrackOne}
																	   setCircleOne={setCircleOne}
																	   setTrackThree={setTrackThree}
																	   setCircleFour={setCircleFour}
                                                                       updatePriceBreakDown={updatePriceBreakDown}
                                                                       defaultChecked={getDefaultCheck(charge.name)}/>
                                        }
                                    })}
                                </React.Fragment>)
                            }
                        })}
                        </tbody>
                    </table>
                </div>
            </AccordionBody>
        </AccordionItem>
    </Accordion>);
};

export default ShippingDetails;
