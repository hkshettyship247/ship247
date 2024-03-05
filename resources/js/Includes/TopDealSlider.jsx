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
      const constants = this.props.constants;

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
                                    <div className="topdeal-box mb-5">
                                        <div className="inner-box flex-col gap-6">
                                            <div className="flex w-full items-center">
                                                <div className="w-7/12">
                                                    <div className="flex items-center">
                                                        { (parseInt(deal?.route_type) === constants.ROUTE_TYPE_SEA)? 
                                                        <>
                                                            <i className="icon ship">
                                                                <img src="/images/svg/ship.svg" alt=""/>
                                                            </i>
                                                            <p className="container-size">
                                                                <span>Sea</span>
                                                                {deal?.container_size?.display_label}
                                                            </p>
                                                        </>
                                                        :
                                                        <>
                                                        <i class="icon"><svg id="truck-icon" xmlns="http://www.w3.org/2000/svg" width="" height="" viewBox="0 0 23.119 28.33"><path id="Path_739" data-name="Path 739" d="M120,318.485h8.381a.484.484,0,0,0,0-.968H120a.484.484,0,0,0,0,.968" transform="translate(-112.628 -299.227)" fill="#10b44c"></path><path id="Path_740" data-name="Path 740" d="M128.377,352.007H120a.484.484,0,0,0,0,.968h8.381a.484.484,0,0,0,0-.968" transform="translate(-112.628 -331.73)" fill="#10b44c"></path><path id="Path_741" data-name="Path 741" d="M22.977,11.951a.484.484,0,0,0-.343-.141H20.656V8.635a1.581,1.581,0,0,0-.066-.448.481.481,0,0,0,.065-.242V.484A.484.484,0,0,0,20.172,0H2.946a.484.484,0,0,0-.484.484V7.945a.481.481,0,0,0,.066.243,1.582,1.582,0,0,0-.066.447V11.81H.484A.484.484,0,0,0,0,12.294V16.67a.484.484,0,0,0,.484.484H2.462v5.482a.486.486,0,0,0-.013.111h0v1.761a1.431,1.431,0,0,0,1.232,1.416V27.24A1.091,1.091,0,0,0,4.77,28.33H7.84A1.091,1.091,0,0,0,8.93,27.24V25.915l5.8-.1V27.24a1.091,1.091,0,0,0,1.089,1.09h3.07a1.091,1.091,0,0,0,1.089-1.09V25.72h.016a1.428,1.428,0,0,0,.678-1.21V22.748a.482.482,0,0,0-.014-.113v-5.48h1.979a.484.484,0,0,0,.484-.484V12.294a.484.484,0,0,0-.142-.343M2.462,16.186H.968V12.778H2.462Zm.968.8H19.688v5.282H3.43ZM19.688,8.635V9.85H3.43V8.635a.613.613,0,0,1,.613-.611H19.075a.613.613,0,0,1,.613.611M3.43,10.817H19.688v5.2H3.43ZM19.688.968V7.18a1.58,1.58,0,0,0-.613-.124H4.043a1.581,1.581,0,0,0-.613.124V.968ZM3.417,24.509V23.232H19.7v1.277a.461.461,0,0,1-.231.4.48.48,0,0,0-.2.061c-.011,0-.021,0-.032,0H3.879a.463.463,0,0,1-.462-.462M7.962,27.24a.121.121,0,0,1-.122.122H4.77a.121.121,0,0,1-.122-.122v-1.3H7.562l.4-.007Zm11.047,0a.121.121,0,0,1-.122.122h-3.07a.121.121,0,0,1-.122-.122V25.8l3.314-.059Zm3.142-11.053H20.656V12.778h1.5Z" fill="#10b44c"></path></svg></i>

                                                        <p className="container-size">
                                                            <span>Land</span>
                                                            {deal?.container_size?.display_label}
                                                        </p>
                                                        </>
                                                        }
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
