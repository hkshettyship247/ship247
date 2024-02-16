import React, { Component } from 'react';
import Slider from "react-slick";
import {Link} from "@inertiajs/react";
import { currencyFormatter } from "../../views/helpers/helpers";
import BookNowButton, {PLACEMENT_MAIN_RESULT} from "@/Components/BookNowButton";

export default class TopDealSlider extends Component {
    constructor(props) {
        super(props);
        this.next = this.next.bind(this);
        this.previous = this.previous.bind(this);
      }
      next() {
        this.slider.slickNext();
      }
      previous() {
        this.slider.slickPrev();
      }
    render() {
      const settings = {
        dots: false,
        arrows: false,
        infinite: true,
        speed: 500,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        responsive: [
            {
              breakpoint: 1200,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
                infinite: true,
                dots: true
              }
            },
            {
              breakpoint: 767,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: true
              }
            }
          ]
      };
      return (
        <div className="bg-white">
            <section className="max-w-screen-4xl mx-auto">
                <div className="top-deals-section default-container">
                    <div className="relative">
                        <h2 className="default-heading">
                        Hot DEALS
                        </h2>

                        <div className='absolute top-8 right-0 hidden md:block'>
                            <Link href="/hot-deals" className="default-button red">
                                <span>view all</span>
                            </Link>
                        </div>
                    </div>

                        {/* <div className="slider-arrows desktop-arrows">
                            <a href="javascript:;" className="topdeals-image-prev" onClick={this.previous}>
                                <img src="/images/svg/left-arrow-icon.svg" alt="" />
                            </a>
                            <a href="javascript:;" className="topdeals-image-next" onClick={this.next}>
                                <img src="/images/svg/right-arrow-icon.svg" alt="" />
                            </a>
                        </div> */}

                        <Slider ref={c => (this.slider = c)} {...settings} className="topdeals-image-slider">
                            {this.props?.deals?.map(deal => {
                               return (<div className="item" key={deal.id}>
                                    <div className="topdeal-box">
                                        <div className="inner-box flex-col gap-6">
                                            <div className="flex w-full items-center">
                                                <div className="w-7/12">
                                                    <div className="flex items-center">
                                                    <i className="icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 98 98">
                                                        <g id="Group_228" data-name="Group 228" transform="translate(-754 -1432)">
                                                            <rect id="Rectangle_104" data-name="Rectangle 104" width="98" height="98" rx="20" transform="translate(754 1432)" fill="#f0e9ff"/>
                                                            <g id="truck-icon" transform="translate(783 1457)">
                                                            <path id="Path_739" data-name="Path 739" d="M120.332,319.157h14.2a.82.82,0,0,0,0-1.64h-14.2a.82.82,0,0,0,0,1.64" transform="translate(-107.848 -286.527)" fill="#423460"/>
                                                            <path id="Path_740" data-name="Path 740" d="M134.533,352.007h-14.2a.82.82,0,0,0,0,1.64h14.2a.82.82,0,0,0,0-1.64" transform="translate(-107.848 -317.651)" fill="#423460"/>
                                                            <path id="Path_741" data-name="Path 741" d="M38.931,20.25a.821.821,0,0,0-.581-.24H35V14.63a2.68,2.68,0,0,0-.111-.759.815.815,0,0,0,.111-.41V.82a.82.82,0,0,0-.82-.82H4.991a.82.82,0,0,0-.82.82V13.461a.815.815,0,0,0,.111.412,2.681,2.681,0,0,0-.111.758v5.38H.82a.82.82,0,0,0-.82.82v7.415a.82.82,0,0,0,.82.82H4.172v9.289a.824.824,0,0,0-.023.189h0v2.984a2.425,2.425,0,0,0,2.088,2.4v2.228A1.848,1.848,0,0,0,8.083,48h5.2a1.848,1.848,0,0,0,1.846-1.846V43.909l9.824-.174v2.419A1.848,1.848,0,0,0,26.8,48H32a1.848,1.848,0,0,0,1.846-1.846V43.578h.028a2.419,2.419,0,0,0,1.148-2.051V38.543A.817.817,0,0,0,35,38.351V29.065h3.353a.82.82,0,0,0,.82-.82V20.831a.82.82,0,0,0-.24-.581M4.172,27.426H1.64V21.65H4.172Zm1.64,1.348H33.359v8.949H5.811ZM33.359,14.631v2.058H5.811V14.631A1.039,1.039,0,0,1,6.85,13.6H32.32a1.039,1.039,0,0,1,1.039,1.035m-27.547,3.7H33.359v8.806H5.811ZM33.358,1.639V12.166a2.678,2.678,0,0,0-1.038-.21H6.85a2.679,2.679,0,0,0-1.039.21V1.639ZM5.789,41.527V39.362H33.381v2.164a.781.781,0,0,1-.391.675.813.813,0,0,0-.338.1c-.018,0-.035.005-.054.005H6.572a.784.784,0,0,1-.783-.783m7.7,4.627a.2.2,0,0,1-.206.207h-5.2a.205.205,0,0,1-.206-.207v-2.2h4.937l.678-.012Zm18.717,0a.2.2,0,0,1-.206.207H26.8a.205.205,0,0,1-.206-.207V43.707l5.615-.1Zm5.323-18.728H35V21.65h2.534Z" fill="#423460"/>
                                                            </g>
                                                        </g>
                                                        </svg>
                                                        </i>

                                                        {/* <i className="icon ship">
                                                            <img src="/images/svg/ship.svg" alt=""/>
                                                        </i> */}
                                                        <p className="container-size">
                                                            <span>container</span>
                                                            {deal?.container_size?.display_label}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div className="w-5/12 ml-auto">
                                                    <p className="pricing ml-auto">
                                                        <span>Starting From</span>
                                                        {currencyFormatter(deal?.price_amount)}
                                                    </p>
                                                </div>
                                            </div>

                                            <div className="flex w-full sm:flex-row flex-col sm:gap-0 gap-4">
                                                <div className="w-7/12">
                                                    <p className="country">
                                                        <span>Origin</span>
                                                        {(deal?.origin?.city ?? deal?.origin?.port) + ', ' + deal?.origin?.country?.code}
                                                    </p>
                                                </div>
                                                <div className="w-5/12 sm:ml-auto ml-0">
                                                    <p className="country">
                                                        <span>Destination</span>
                                                        {(deal?.destination?.city ?? deal?.destination?.port) + ', ' + deal?.destination?.country?.code}
                                                    </p>
                                               </div>
                                            </div>

                                            <BookNowButton placement={PLACEMENT_MAIN_RESULT} data={deal} />
                                            
                                        </div>
                                    </div>
                                </div>)
                            })}
                        </Slider>

                        <div className='text-center mt-12 block md:hidden'>
                            <Link href="/hot-deals" className="default-button red">
                                <span>view all deals</span>
                            </Link>
                        </div>

                    {/* <div className="slider-arrows mobile-arrows">
                        <a href="javascript:;" className="topdeals-image-prev" onClick={this.previous}>
                            <img src="/images/svg/left-arrow-icon.svg" alt="" />
                        </a>
                        <a href="javascript:;" className="topdeals-image-next" onClick={this.next}>
                            <img src="/images/svg/right-arrow-icon.svg" alt="" />
                        </a>
                    </div> */}
                </div>
            </section>
        </div>
      );
    }
}
