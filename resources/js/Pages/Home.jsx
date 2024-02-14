import { Head } from '@inertiajs/react';
import Benefits from '@/Includes/BenefitSlider';
import Services from '@/Includes/ServiceSlider';
import RegistrationCta from '@/Includes/RegisterCta';
import LatestNews from '@/Includes/LatestNews';
import ClientsLogo from '@/Includes/ClientLogos';
import TopDealSlider from '@/Includes/TopDealSlider';
import SearchbarForm from "@/Components/SearchbarForm";

export default function Home({hot_deals_collection, news_listing, user_details}) {
    const handleSearchbarFormCallback = (values) => {
        const query = new URLSearchParams(values);
        window.location = route('pages.searchresults') + '?' + query.toString();
    }

    return (
        <>
            <Head title="Home" />

            {/* Banner */}
            <section className="banner-bg-area test">
                <section className="max-w-screen-4xl mx-auto">
                    <div className="homepage-banner default-container">
                        <div className="content">
                            <h4 className="subtitle">SHIPPING MADE PERSONAL</h4>
                            <h2 className="title">YOUR NEEDS, OUR PRIORITY</h2>
                            <h6 className="desc">IF YOU CAN'T FIND IT HERE, WE'LL GET IT FOR YOU</h6>
                        </div>

                        <div className="search-panel">
                            <SearchbarForm callback={handleSearchbarFormCallback} user_details={user_details ?? null}/>
                        </div>
                    </div>
                </section>

                <Benefits />
            </section>

            {/* Top Deals */}
            <TopDealSlider deals={hot_deals_collection?.data ?? []}/>

            {/* Services */}
            <Services />

            {/* Register CTA */}
            <RegistrationCta />

            {/* Latest News */}
            <LatestNews news={news_listing}/>

            {/* Client Logos */}
            <ClientsLogo />

        </>
    )
}
