import AboutContact from "@/components/AboutContact";
import Footer from "@/components/Footer";
import Header from "@/components/Header";
import Hero from "@/components/Hero";
import ServicesAmenities from "@/components/ServicesAmenities";
import Workspaces from "@/components/Workspaces";

export default function Home() {
  return (
    <>
      <Header />
      <main className="flex-1">
        <Hero />
        <Workspaces />
        <ServicesAmenities />
        <AboutContact />
      </main>
      <Footer />
    </>
  );
}
