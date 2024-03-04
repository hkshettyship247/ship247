@if($booking->transportation == \App\Models\Booking::LAND)
    <div class="step-content-1">
        <div class="mb-2 d-flex rouded-circle">
            <h4><strong>{{isset($booking->origin->fullname) ? $booking->origin->fullname :
                    ''}}</strong></h4>
        </div>
        <div class="flex">
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head mb-4">Movement Type</span>
                        <span class="value flex">
                            <svg id="truck-icon" xmlns="http://www.w3.org/2000/svg" width="20"
                                height="20" viewBox="0 0 23.119 28.33">
                                <path id="Path_739" data-name="Path 739"
                                    d="M120,318.485h8.381a.484.484,0,0,0,0-.968H120a.484.484,0,0,0,0,.968"
                                    transform="translate(-112.628 -299.227)" fill="#10b44c"></path>
                                <path id="Path_740" data-name="Path 740"
                                    d="M128.377,352.007H120a.484.484,0,0,0,0,.968h8.381a.484.484,0,0,0,0-.968"
                                    transform="translate(-112.628 -331.73)" fill="#10b44c"></path>
                                <path id="Path_741" data-name="Path 741"
                                    d="M22.977,11.951a.484.484,0,0,0-.343-.141H20.656V8.635a1.581,1.581,0,0,0-.066-.448.481.481,0,0,0,.065-.242V.484A.484.484,0,0,0,20.172,0H2.946a.484.484,0,0,0-.484.484V7.945a.481.481,0,0,0,.066.243,1.582,1.582,0,0,0-.066.447V11.81H.484A.484.484,0,0,0,0,12.294V16.67a.484.484,0,0,0,.484.484H2.462v5.482a.486.486,0,0,0-.013.111h0v1.761a1.431,1.431,0,0,0,1.232,1.416V27.24A1.091,1.091,0,0,0,4.77,28.33H7.84A1.091,1.091,0,0,0,8.93,27.24V25.915l5.8-.1V27.24a1.091,1.091,0,0,0,1.089,1.09h3.07a1.091,1.091,0,0,0,1.089-1.09V25.72h.016a1.428,1.428,0,0,0,.678-1.21V22.748a.482.482,0,0,0-.014-.113v-5.48h1.979a.484.484,0,0,0,.484-.484V12.294a.484.484,0,0,0-.142-.343M2.462,16.186H.968V12.778H2.462Zm.968.8H19.688v5.282H3.43ZM19.688,8.635V9.85H3.43V8.635a.613.613,0,0,1,.613-.611H19.075a.613.613,0,0,1,.613.611M3.43,10.817H19.688v5.2H3.43ZM19.688.968V7.18a1.58,1.58,0,0,0-.613-.124H4.043a1.581,1.581,0,0,0-.613.124V.968ZM3.417,24.509V23.232H19.7v1.277a.461.461,0,0,1-.231.4.48.48,0,0,0-.2.061c-.011,0-.021,0-.032,0H3.879a.463.463,0,0,1-.462-.462M7.962,27.24a.121.121,0,0,1-.122.122H4.77a.121.121,0,0,1-.122-.122v-1.3H7.562l.4-.007Zm11.047,0a.121.121,0,0,1-.122.122h-3.07a.121.121,0,0,1-.122-.122V25.8l3.314-.059Zm3.142-11.053H20.656V12.778h1.5Z"
                                    fill="#10b44c"></path>
                            </svg>
                            Land
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex flex-col">
                    <div>
                        <span class="head mb-4">Event</span>
                    </div>
                    <div>
                        <span class="value mb-4">Departure</span>
                    </div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head mb-4">Date</span>
                        <span class="value flex">
                            {{ isset($track_booking_response['data']) ?
                            Carbon\Carbon::parse($track_booking_response['data']?->originPortActualDepartureUtc)->setTimezone('UTC')->format('Y-m-d
                            H:i') : '-' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head mb-4">Trip Number</span>
                        <span class="value flex">
                            {{ isset($track_booking_response['data']) ?
                            $track_booking_response['data']?->transportDocumentId : '-' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head mb-4">Transport Name</span>
                        <span class="value flex">
                            {{ isset($track_booking_response['data']) ?
                            $track_booking_response['data']?->carrier : '-' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head mb-4">Notes</span>
                        <span class="value flex">
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="step-content-1">
        <div class="mb-2 d-flex rouded-circle">
            <h4><strong>{{isset($booking->destination->fullname) ? $booking->destination->fullname :
                    ''}}</strong></h4>
        </div>
        <div class="flex">
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head mb-4">Movement Type</span>
                        <span class="value flex">
                            <svg id="truck-icon" xmlns="http://www.w3.org/2000/svg" width="20"
                                height="20" viewBox="0 0 23.119 28.33">
                                <path id="Path_739" data-name="Path 739"
                                    d="M120,318.485h8.381a.484.484,0,0,0,0-.968H120a.484.484,0,0,0,0,.968"
                                    transform="translate(-112.628 -299.227)" fill="#10b44c"></path>
                                <path id="Path_740" data-name="Path 740"
                                    d="M128.377,352.007H120a.484.484,0,0,0,0,.968h8.381a.484.484,0,0,0,0-.968"
                                    transform="translate(-112.628 -331.73)" fill="#10b44c"></path>
                                <path id="Path_741" data-name="Path 741"
                                    d="M22.977,11.951a.484.484,0,0,0-.343-.141H20.656V8.635a1.581,1.581,0,0,0-.066-.448.481.481,0,0,0,.065-.242V.484A.484.484,0,0,0,20.172,0H2.946a.484.484,0,0,0-.484.484V7.945a.481.481,0,0,0,.066.243,1.582,1.582,0,0,0-.066.447V11.81H.484A.484.484,0,0,0,0,12.294V16.67a.484.484,0,0,0,.484.484H2.462v5.482a.486.486,0,0,0-.013.111h0v1.761a1.431,1.431,0,0,0,1.232,1.416V27.24A1.091,1.091,0,0,0,4.77,28.33H7.84A1.091,1.091,0,0,0,8.93,27.24V25.915l5.8-.1V27.24a1.091,1.091,0,0,0,1.089,1.09h3.07a1.091,1.091,0,0,0,1.089-1.09V25.72h.016a1.428,1.428,0,0,0,.678-1.21V22.748a.482.482,0,0,0-.014-.113v-5.48h1.979a.484.484,0,0,0,.484-.484V12.294a.484.484,0,0,0-.142-.343M2.462,16.186H.968V12.778H2.462Zm.968.8H19.688v5.282H3.43ZM19.688,8.635V9.85H3.43V8.635a.613.613,0,0,1,.613-.611H19.075a.613.613,0,0,1,.613.611M3.43,10.817H19.688v5.2H3.43ZM19.688.968V7.18a1.58,1.58,0,0,0-.613-.124H4.043a1.581,1.581,0,0,0-.613.124V.968ZM3.417,24.509V23.232H19.7v1.277a.461.461,0,0,1-.231.4.48.48,0,0,0-.2.061c-.011,0-.021,0-.032,0H3.879a.463.463,0,0,1-.462-.462M7.962,27.24a.121.121,0,0,1-.122.122H4.77a.121.121,0,0,1-.122-.122v-1.3H7.562l.4-.007Zm11.047,0a.121.121,0,0,1-.122.122h-3.07a.121.121,0,0,1-.122-.122V25.8l3.314-.059Zm3.142-11.053H20.656V12.778h1.5Z"
                                    fill="#10b44c"></path>
                            </svg>
                            Land
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex flex-col">
                    <div>
                        <span class="head mb-4">Event</span>
                    </div>
                    <div>
                        <span class="value mb-4">Departure</span>
                    </div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head mb-4">Date</span>
                        <span class="value flex">
                            {{ isset($track_booking_response['data']) ?
                            Carbon\Carbon::parse($track_booking_response['data']?->originPortActualDepartureUtc)->setTimezone('UTC')->format('Y-m-d
                            H:i') : '-' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head mb-4">Trip Number</span>
                        <span class="value flex">
                            {{ isset($track_booking_response['data']) ?
                            $track_booking_response['data']?->transportDocumentId : '-' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head mb-4">Transport Name</span>
                        <span class="value flex">
                            {{ isset($track_booking_response['data']) ?
                            $track_booking_response['data']?->carrier : '-' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head mb-4">Notes</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="step-content-1">
        <div class="mb-2 d-flex rouded-circle">
            <h4><strong>{{isset($booking->origin->port) ? $booking->origin->port : ''}}</strong>
            </h4>
        </div>
        <div class="flex">
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head mb-4">Movement Type</span>
                        <span class="value flex">
                            <img src="/images/svg/truck-icon.svg" class="mr-2" alt="">
                            Land
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex flex-col">
                    <div>
                        <span class="head mb-4">Event</span>
                    </div>
                    <div>
                        <span class="value mb-4">Departure</span>
                    </div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head mb-4">Date</span>
                        <span class="value flex">
                            {{ isset($track_booking_response['data']) ?
                            Carbon\Carbon::parse($track_booking_response['data']?->originPortActualDepartureUtc)->setTimezone('UTC')->format('Y-m-d
                            H:i') : '-' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head mb-4">Trip Number</span>
                        <span class="value flex">
                            {{ isset($track_booking_response['data']) ?
                            $track_booking_response['data']?->transportDocumentId : '-' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head mb-4">Transport Name</span>
                        <span class="value flex">
                            {{ isset($track_booking_response['data']) ?
                            $track_booking_response['data']?->carrier : '-' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head mb-4">Notes</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="step-content-1">
        <div class="mb-2 d-flex rouded-circle">
            <h4><strong>{{ $booking->origin->code }}</strong></h4>
        </div>
        <div class="flex">
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head mb-4">Movement Type</span>
                        <span class="value flex"><svg id="ship" class="mr-2"
                                xmlns="http://www.w3.org/2000/svg" width="15.603" height="18"
                                viewBox="0 0 15.603 18">
                                <path id="Path_730" data-name="Path 730"
                                    d="M12.037,455.389a2.056,2.056,0,0,1-1.3-.471l-.01-.008a1.241,1.241,0,0,0-1.624,0,2.021,2.021,0,0,1-2.611,0,1.241,1.241,0,0,0-1.624,0,2.021,2.021,0,0,1-2.611,0,1.242,1.242,0,0,0-1.624,0,.39.39,0,0,1-.494-.6,2.02,2.02,0,0,1,2.611,0,1.242,1.242,0,0,0,1.624,0,2.02,2.02,0,0,1,2.611,0,1.242,1.242,0,0,0,1.624,0,2.018,2.018,0,0,1,2.6-.008l.01.008a1.241,1.241,0,0,0,1.624,0,2.021,2.021,0,0,1,2.611,0,.39.39,0,0,1-.494.6,1.242,1.242,0,0,0-1.624,0,2.057,2.057,0,0,1-1.305.478Z"
                                    transform="translate(0 -437.389)" fill="#423460" />
                                <path id="Path_731" data-name="Path 731"
                                    d="M32.825,206.319a2.053,2.053,0,0,1-1.308-.478,1.266,1.266,0,0,0-1.624,0,2.028,2.028,0,0,1-2.611,0,1.254,1.254,0,0,0-1.62,0,2.051,2.051,0,0,1-1.309.48l-.074,0a.365.365,0,0,1-.35-.266l-2.341-7.017a.39.39,0,0,1,.2-.476l6.6-3.121a.387.387,0,0,1,.332,0l6.663,3.121a.39.39,0,0,1,.2.477l-2.341,7.017a.39.39,0,0,1-.37.267.31.31,0,0,1-.055,0Zm-6.354-1.56a2.03,2.03,0,0,1,1.306.48,1.246,1.246,0,0,0,1.623,0,2.063,2.063,0,0,1,2.613,0,1.317,1.317,0,0,0,.591.28l2.136-6.405-6.182-2.9-6.121,2.894,2.137,6.407a1.322,1.322,0,0,0,.592-.283,2.03,2.03,0,0,1,1.3-.478Z"
                                    transform="translate(-20.786 -188.319)" fill="#423460" />
                                <path id="Path_732" data-name="Path 732"
                                    d="M85.159,61.97a.387.387,0,0,1-.165-.037L80.448,59.8l-4.484,2.121a.39.39,0,0,1-.557-.353V57.366a.39.39,0,0,1,.39-.39h1.17v-2.73a.39.39,0,0,1,.39-.39H83.6a.39.39,0,0,1,.39.39v2.73h1.17a.39.39,0,0,1,.39.39v4.214a.39.39,0,0,1-.39.39Zm-4.712-2.988a.385.385,0,0,1,.165.037l4.157,1.947v-3.21H83.6a.39.39,0,0,1-.39-.39V54.635H77.748v2.731a.39.39,0,0,1-.39.39h-1.17v3.2l4.093-1.937a.394.394,0,0,1,.167-.037Z"
                                    transform="translate(-72.676 -51.904)" fill="#423460" />
                                <path id="Path_733" data-name="Path 733"
                                    d="M185.03,2.731h-1.56a.39.39,0,0,1-.39-.39V.78a.781.781,0,0,1,.78-.78h.78a.781.781,0,0,1,.78.78v1.56a.39.39,0,0,1-.39.39Zm-1.17-.78h.78V.78h-.78Z"
                                    transform="translate(-176.449)" fill="#423460" />
                                <path id="Path_734" data-name="Path 734"
                                    d="M205,216.691a.39.39,0,0,1-.39-.39v-9.752a.39.39,0,1,1,.78,0V216.3a.39.39,0,0,1-.39.39"
                                    transform="translate(-197.197 -198.692)" fill="#423460" />
                            </svg>
                            Ship</span>
                    </div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex flex-col">
                    <div>
                        <span class="head mb-4">Event</span>
                    </div>
                    <div>
                        <span class="value mb-4">Arrival</span>
                    </div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head mb-4">Date</span>
                        <span class="value flex">
                            {{ isset($track_booking_response['data']) ?
                            Carbon\Carbon::parse($track_booking_response['data']?->originPortActualDepartureUtc)->setTimezone('UTC')->format('Y-m-d
                            H:i') : '-' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head mb-4">Trip Number</span>
                        <span class="value flex">
                            {{ isset($track_booking_response['data']) ?
                            $track_booking_response['data']?->transportDocumentId : '-' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head mb-4">Transport Name</span>
                        <span class="value flex">
                            {{ isset($track_booking_response['data']) ?
                            $track_booking_response['data']?->carrier : '-' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head mb-4">Notes</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex">
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head mb-4">Movement Type</span>
                        <span class="value flex"><svg id="ship" class="mr-2"
                                xmlns="http://www.w3.org/2000/svg" width="15.603" height="18"
                                viewBox="0 0 15.603 18">
                                <path id="Path_730" data-name="Path 730"
                                    d="M12.037,455.389a2.056,2.056,0,0,1-1.3-.471l-.01-.008a1.241,1.241,0,0,0-1.624,0,2.021,2.021,0,0,1-2.611,0,1.241,1.241,0,0,0-1.624,0,2.021,2.021,0,0,1-2.611,0,1.242,1.242,0,0,0-1.624,0,.39.39,0,0,1-.494-.6,2.02,2.02,0,0,1,2.611,0,1.242,1.242,0,0,0,1.624,0,2.02,2.02,0,0,1,2.611,0,1.242,1.242,0,0,0,1.624,0,2.018,2.018,0,0,1,2.6-.008l.01.008a1.241,1.241,0,0,0,1.624,0,2.021,2.021,0,0,1,2.611,0,.39.39,0,0,1-.494.6,1.242,1.242,0,0,0-1.624,0,2.057,2.057,0,0,1-1.305.478Z"
                                    transform="translate(0 -437.389)" fill="#423460" />
                                <path id="Path_731" data-name="Path 731"
                                    d="M32.825,206.319a2.053,2.053,0,0,1-1.308-.478,1.266,1.266,0,0,0-1.624,0,2.028,2.028,0,0,1-2.611,0,1.254,1.254,0,0,0-1.62,0,2.051,2.051,0,0,1-1.309.48l-.074,0a.365.365,0,0,1-.35-.266l-2.341-7.017a.39.39,0,0,1,.2-.476l6.6-3.121a.387.387,0,0,1,.332,0l6.663,3.121a.39.39,0,0,1,.2.477l-2.341,7.017a.39.39,0,0,1-.37.267.31.31,0,0,1-.055,0Zm-6.354-1.56a2.03,2.03,0,0,1,1.306.48,1.246,1.246,0,0,0,1.623,0,2.063,2.063,0,0,1,2.613,0,1.317,1.317,0,0,0,.591.28l2.136-6.405-6.182-2.9-6.121,2.894,2.137,6.407a1.322,1.322,0,0,0,.592-.283,2.03,2.03,0,0,1,1.3-.478Z"
                                    transform="translate(-20.786 -188.319)" fill="#423460" />
                                <path id="Path_732" data-name="Path 732"
                                    d="M85.159,61.97a.387.387,0,0,1-.165-.037L80.448,59.8l-4.484,2.121a.39.39,0,0,1-.557-.353V57.366a.39.39,0,0,1,.39-.39h1.17v-2.73a.39.39,0,0,1,.39-.39H83.6a.39.39,0,0,1,.39.39v2.73h1.17a.39.39,0,0,1,.39.39v4.214a.39.39,0,0,1-.39.39Zm-4.712-2.988a.385.385,0,0,1,.165.037l4.157,1.947v-3.21H83.6a.39.39,0,0,1-.39-.39V54.635H77.748v2.731a.39.39,0,0,1-.39.39h-1.17v3.2l4.093-1.937a.394.394,0,0,1,.167-.037Z"
                                    transform="translate(-72.676 -51.904)" fill="#423460" />
                                <path id="Path_733" data-name="Path 733"
                                    d="M185.03,2.731h-1.56a.39.39,0,0,1-.39-.39V.78a.781.781,0,0,1,.78-.78h.78a.781.781,0,0,1,.78.78v1.56a.39.39,0,0,1-.39.39Zm-1.17-.78h.78V.78h-.78Z"
                                    transform="translate(-176.449)" fill="#423460" />
                                <path id="Path_734" data-name="Path 734"
                                    d="M205,216.691a.39.39,0,0,1-.39-.39v-9.752a.39.39,0,1,1,.78,0V216.3a.39.39,0,0,1-.39.39"
                                    transform="translate(-197.197 -198.692)" fill="#423460" />
                            </svg>
                            Ship</span>
                    </div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex flex-col">
                    <div>
                        <span class="head mb-4">Event</span>
                    </div>
                    <div>
                        <span class="value mb-4">Departure</span>
                    </div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head mb-4">Date</span>
                        <span class="value flex">
                            {{ isset($track_booking_response['data']) ?
                            Carbon\Carbon::parse($track_booking_response['data']?->finalPortActualArrivalUtc)->setTimezone('UTC')->format('Y-m-d
                            H:i') : '-' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head mb-4">Trip Number</span>
                        <span class="value flex">
                            {{ isset($track_booking_response['data']) ?
                            $track_booking_response['data']?->transportDocumentId : '-' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head mb-4">Transport Name</span>
                        <span class="value flex">
                            {{ isset($track_booking_response['data']) ?
                            $track_booking_response['data']?->carrier : '-' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head mb-4">Notes</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="step-content-1">
        <div class="mb-2 d-flex rouded-circle">
            <h4><strong>{{isset($booking->destination->port) ? $booking->destination->port :
                    ''}}</strong></h4>
        </div>
        <div class="flex">
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head mb-4">Movement Type</span>
                        <span class="value flex">
                            <img src="/images/svg/truck-icon.svg" class="mr-2" alt="">
                            Land
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex flex-col">
                    <div>
                        <span class="head mb-4">Event</span>
                    </div>
                    <div>
                        <span class="value mb-4">Departure</span>
                    </div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head mb-4">Date</span>
                        <span class="value flex">
                            {{ isset($track_booking_response['data']) ?
                            Carbon\Carbon::parse($track_booking_response['data']?->finalPortActualArrivalUtc)->setTimezone('UTC')->format('Y-m-d
                            H:i') : '-' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head mb-4">Trip Number</span>
                        <span class="value flex">
                            {{ isset($track_booking_response['data']) ?
                            $track_booking_response['data']?->transportDocumentId : '-' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head mb-4">Transport Name</span>
                        <span class="value flex">
                            {{ isset($track_booking_response['data']) ?
                            $track_booking_response['data']?->carrier : '-' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head mb-4">Notes</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif