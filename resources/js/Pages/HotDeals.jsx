import {Head, usePage} from "@inertiajs/react";
import Radiobox from "@/Components/Radiobox";
import SearchResultCard from "@/Components/SearchResultCard";
import {Tabs} from "antd";
import Checkbox from "@/Components/Checkbox";
import {useEffect, useReducer, useState} from "react";

const toggleFromArray = (needle, haystack) => {
    if(haystack.includes(needle)) {
        haystack = haystack.filter(item => item !== needle);
    } else {
        haystack.push(needle);
    }
    return haystack;
}

const filtersReducer = (state, action) => {
    if ('route_type' === action.type) {
        return Object.assign({}, state, {routeType: action.value});
    } else if ('sort_by' === action.type) {
        return Object.assign({}, state, {sortBy: action.value});
    } else if ('container_size' === action.type) {
        return Object.assign({}, state, {containerSizes: toggleFromArray(action.value, state.containerSizes)});
    } else if ('truck_type' === action.type) {
        return Object.assign({}, state, {truckTypes: toggleFromArray(action.value, state.truckTypes)});
    } else if ('axle_type' === action.type) {
        return Object.assign({}, state, {axleTypes: toggleFromArray(action.value, state.axleTypes)});
    } else if ('shipping_line' === action.type) {
        let shipping_lines = state.shippingLines[state.routeType];
        shipping_lines = toggleFromArray(action.value, shipping_lines);
        state.shippingLines[state.routeType] = shipping_lines;
        return Object.assign({}, state);
    }
    return state;
}

const SORT_BY_ETD = 1;
const SORT_BY_FASTEST = 2;
const SORT_BY_CHEAPEST = 3;

export default function HotDeals({hot_deals_collection, options, filtersDefault}) {
    const [results, setResults] = useState(hot_deals_collection?.data ?? []);
    const [processedResult, setProcessedResult] = useState([]);
    const {constants} = usePage().props;
    const chargeTypes = {
        pickup: true,
        origin: true,
        freight: true,
        destination: true,
        delivery: true,
    }

    const [filters, dispatchFilters] = useReducer(filtersReducer, filtersDefault)

    useEffect(() => {
        let _processedResults = results
            .filter(result => result.route_type === filters.routeType);

        _processedResults = _processedResults
            .filter(result => filters.shippingLines[filters.routeType].includes(`${result.company?.id}`));

        if (constants.ROUTE_TYPE_SEA === filters.routeType) {
            _processedResults = _processedResults.filter(result => filters.containerSizes.includes(`${result.container_size?.value}`));
        }

        if (constants.ROUTE_TYPE_LAND === filters.routeType) {
            _processedResults = _processedResults
                .filter(result => filters.truckTypes.includes(`${result.truck_type_id}`))
                .filter(result => filters.axleTypes.includes(`${result.axle}`));
        }

        if (SORT_BY_ETD === filters.sortBy) {
            _processedResults = _processedResults?.sort((item1, item2) => {
                return Date.parse(item1.etd) - Date.parse(item2.etd)
            });
        } else if (SORT_BY_FASTEST === filters.sortBy) {
            _processedResults = _processedResults?.sort((item1, item2) => {
                return item1.tt - item2.tt
            });
        } else if (SORT_BY_CHEAPEST === filters.sortBy) {
            _processedResults = _processedResults?.filter((result) => result.price_amount > 0)
                ?.sort((item1, item2) => {
                    return item1.price_amount - item2.price_amount
                });
        }

        setProcessedResult(_processedResults);

    }, [filters]);


    return (
        <>
            <Head title="Hot Deals"/>

            <section className="max-w-screen-4xl mx-auto">
                <div className='default-container my-16'>
                    <h2 className="default-heading small-heading mb-2">
                        Hot Deals
                    </h2>

                    <div className="flex xl:flex-row flex-col gap-6">
                        <div className="xl:w-3/12">
                            <div className="shadow-box small-box sticky top-0">
                                <div className="filter-box">
                                    <h2 className="default-heading small-size mb-6">
                                        filter
                                    </h2>

                                    <form className="default-form">
                                        <div className="filter-container">
                                            <p className="title">
                                                Route Type
                                            </p>
                                            <div key={`route_type_radio_sea`} className='form-field radio-field'>
                                                <Radiobox value={constants.ROUTE_TYPE_SEA}
                                                          name="route_type"
                                                          onChange={() => dispatchFilters({
                                                              type: 'route_type',
                                                              value: constants.ROUTE_TYPE_SEA
                                                          })}
                                                          checked={constants.ROUTE_TYPE_SEA === filters.routeType}
                                                />
                                                <span className='text'>Sea</span>
                                            </div>
                                            <div key={`route_type_radio_land`} className='form-field radio-field'>
                                                <Radiobox value={constants.ROUTE_TYPE_LAND}
                                                          name="route_type"
                                                          onChange={() => dispatchFilters({
                                                              type: 'route_type',
                                                              value: constants.ROUTE_TYPE_LAND
                                                          })}
                                                          checked={constants.ROUTE_TYPE_LAND === filters.routeType}
                                                />
                                                <span className='text'>Land</span>
                                            </div>
                                        </div>

                                        {/*{constants.ROUTE_TYPE_SEA === filters.routeType ? (
                                            <div className="filter-container">
                                                <p className="title">
                                                    Charge Types
                                                </p>
                                                {chargeTypes.map(charge_type => {
                                                        let charge_type_value = filters.chargeTypes[charge_type.id];

                                                        return (<div key={`charge_type-checkbox-${charge_type.id}`}
                                                                     className='form-field checkbox-field'>
                                                            <Checkbox value={charge_type.id}
                                                                      name="charge_types[]"
                                                                      disabled={charge_type.id === 'freight'}
                                                                      onChange={() => handleFiltersChargeTypeToggle(charge_type.id)}
                                                                      checked={charge_type_value}
                                                            />
                                                            <span className='text'>{charge_type.label}</span>
                                                        </div>)
                                                    }
                                                )}
                                            </div>
                                        ) : null}*/}

                                        {Object.entries(options?.containerSizes).length > 0 && constants.ROUTE_TYPE_SEA === filters.routeType ?
                                            (<div className="filter-container">
                                                <p className="title">
                                                    type of container
                                                </p>
                                                {Object.entries(options?.containerSizes).map(([container_size, container_size_label]) =>
                                                    <div key={`container_size_radio_${container_size}`}
                                                         className='form-field checkbox-field'>
                                                        <Checkbox value={container_size}
                                                                  name="container_sizes[]"
                                                                  onChange={() => dispatchFilters({
                                                                      type: 'container_size',
                                                                      value: container_size
                                                                  })}
                                                                  checked={filters.containerSizes.includes(container_size)}
                                                        />
                                                        <span className='text'>{container_size_label}</span>
                                                    </div>
                                                )}
                                            </div>) : null}

                                        {Object.entries(options?.truckTypes).length > 0 && constants.ROUTE_TYPE_LAND === filters.routeType ?
                                            (<div className="filter-container">
                                                <p className="title">
                                                    type of truck
                                                </p>
                                                {Object.entries(options?.truckTypes).map(([truck_type, truck_type_label]) =>
                                                    <div key={`truck_type_radio_${truck_type}`}
                                                         className='form-field checkbox-field'>
                                                        <Checkbox value={truck_type}
                                                                  name="truck_types[]"
                                                                  onChange={() => dispatchFilters({
                                                                      type: 'truck_type',
                                                                      value: truck_type
                                                                  })}
                                                                  checked={filters.truckTypes.includes(`${truck_type}`)}
                                                        />
                                                        <span className='text'>{truck_type_label}</span>
                                                    </div>)}
                                            </div>) : null}


                                        {Object.entries(options?.axleTypes).length > 0 && constants.ROUTE_TYPE_LAND === filters.routeType
                                            ? (<div className="filter-container">
                                                <p className="title">
                                                    Type of Axle
                                                </p>
                                                {Object.entries(options?.axleTypes).map(([axle_type, axle_type_label]) =>
                                                    <div key={`axle-checkbox-${axle_type}`}
                                                         className='form-field checkbox-field'>
                                                        <Checkbox value={axle_type}
                                                                  name="axle_types[]"
                                                                  onChange={() => dispatchFilters({
                                                                      type: 'axle_type',
                                                                      value: axle_type
                                                                  })}
                                                                  checked={filters.axleTypes.includes(`${axle_type}`)}
                                                        />
                                                        <span className='text'>{axle_type_label}</span>
                                                    </div>
                                                )}
                                            </div>)
                                            : null}

                                        {Object.entries(options?.shippingLines[filters.routeType]).length > 0 ?
                                            <div className="filter-container">
                                                <p className="title">
                                                    SHIPPING LINE
                                                </p>
                                                {Object.entries(options?.shippingLines[filters.routeType]).map(([shipping_line, shipping_line_label]) =>
                                                        <div key={`shipping-line-${shipping_line}`}
                                                                    className='form-field checkbox-field'>
                                                            <Checkbox value={shipping_line}
                                                                      name="shipping_lines[]"
                                                                      onChange={() => dispatchFilters({
                                                                          type: 'shipping_line',
                                                                          value: shipping_line
                                                                      })}
                                                                      checked={filters.shippingLines[filters.routeType].includes(`${shipping_line}`)}
                                                            />
                                                            <span className='text'>{shipping_line_label}</span>
                                                        </div>
                                                )}
                                            </div>
                                         : null}
                                    </form>
                                </div>
                            </div>
                        </div>


                        <div className='xl:w-9/12'>
                            <div className="search-result-filters">
                                <div className="ant-tabs ant-tabs-top ">
                                    <div className="ant-tabs-nav">
                                        <div className="ant-tabs-nav-wrap">
                                            <ul className="ant-tabs-nav-list">
                                                <li key="tab-featured" onClick={() => dispatchFilters({
                                                    type: 'sort_by',
                                                    value: SORT_BY_ETD
                                                })}
                                                    className={`ant-tabs-tab ${filters.sortBy === SORT_BY_ETD ? "ant-tabs-tab-active" : ""}`}>
                                                    <div className="ant-tabs-tab-btn">Featured</div>
                                                </li>
                                                <li key="tab-fastest" onClick={() => dispatchFilters({
                                                    type: 'sort_by',
                                                    value: SORT_BY_FASTEST
                                                })}
                                                    className={`ant-tabs-tab ${filters.sortBy === SORT_BY_FASTEST ? "ant-tabs-tab-active" : ""}`}>
                                                    <div className="ant-tabs-tab-btn">Fastest</div>
                                                </li>
                                                <li key="tab-cheapest" onClick={() => dispatchFilters({
                                                    type: 'sort_by',
                                                    value: SORT_BY_CHEAPEST
                                                })}
                                                    className={`ant-tabs-tab ${filters.sortBy === SORT_BY_CHEAPEST ? "ant-tabs-tab-active" : ""}`}>
                                                    <div className="ant-tabs-tab-btn">Cheapest</div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div className="ant-tabs-nav-operations ant-tabs-nav-operations-hidden">
                                            <button type="button" className="ant-tabs-nav-more"></button>
                                        </div>
                                    </div>
                                    <div className="ant-tabs-content-holder">
                                        <div className="ant-tabs-content ant-tabs-content-top">
                                            <div role="tabpanel" className="ant-tabs-tabpane ant-tabs-tabpane-active">
                                                {/* Match results and prices to show not found if Price is not added*/}
                                                {processedResult.length > 0 ?
                                                    processedResult?.map((result, index) => {
                                                        return (<SearchResultCard
                                                            result={result}
                                                            key={`search-result-card-${result.index}-${index}`}
                                                            filterChargeTypes={chargeTypes}
                                                        />)
                                                    })
                                                    : (
                                                        <div className="shadow-box small-box mb-5">
                                                            <div className="search-result-box">
                                                                <div className="xl:w-100">
                                                                    <h2 className="default-heading small-size">
                                                                        Results Not Found...
                                                                    </h2>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    )
                                                }
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </>
    )
}
