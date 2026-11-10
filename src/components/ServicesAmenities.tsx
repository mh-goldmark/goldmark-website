import Image from "next/image";

const SERVICES = [
  "Virtual office & business address",
  "Reception & mail handling",
  "Business setup referrals",
  "IT & admin support",
] as const;

const AMENITIES = [
  "High-speed connectivity",
  "Meeting & training AV",
  "Premium lounge seating",
  "Secure access control",
  "Printing & pantry",
  "Cityland Mall convenience",
] as const;

export default function ServicesAmenities() {
  return (
    <>
      <section id="services" className="relative overflow-hidden bg-navy py-20 md:py-28">
        <div className="absolute inset-y-0 right-0 hidden w-1/2 lg:block">
          <Image
            src="/images/lounge-coworking.jpg"
            alt="Collaborative coworking lounge with natural light"
            fill
            sizes="50vw"
            className="object-cover opacity-55"
          />
          <div className="absolute inset-0 bg-gradient-to-r from-navy via-navy/70 to-navy/40" />
        </div>

        <div className="relative mx-auto max-w-[1440px] px-5 md:px-8 lg:px-10">
          <div className="max-w-xl">
            <p className="font-sans text-xs font-semibold uppercase tracking-[0.24em] text-gold">
              Services
            </p>
            <h2 className="mt-3 font-heading text-3xl leading-tight text-off-white md:text-4xl">
              Business support beyond the desk
            </h2>
            <p className="mt-4 font-sans text-base leading-relaxed text-beige/85 md:text-lg">
              Concierge-level support so your team can focus on clients, growth,
              and delivery — not logistics.
            </p>
            <ul className="mt-10 space-y-4">
              {SERVICES.map((service) => (
                <li
                  key={service}
                  className="flex items-start gap-3 font-sans text-sm text-off-white/90 md:text-base"
                >
                  <span className="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-gold" />
                  {service}
                </li>
              ))}
            </ul>
          </div>
        </div>
      </section>

      <section id="amenities" className="bg-beige py-20 text-charcoal md:py-28">
        <div className="mx-auto grid max-w-[1440px] items-center gap-12 px-5 md:px-8 lg:grid-cols-2 lg:gap-16 lg:px-10">
          <div className="relative min-h-[18rem] overflow-hidden md:min-h-[24rem]">
            <Image
              src="/images/lounge-amenities.jpg"
              alt="Warm lounge seating in a premium business center"
              fill
              sizes="(max-width: 1024px) 100vw, 50vw"
              className="object-cover"
            />
          </div>
          <div>
            <p className="font-sans text-xs font-semibold uppercase tracking-[0.24em] text-gold">
              Amenities
            </p>
            <h2 className="mt-3 font-heading text-3xl leading-tight text-navy md:text-4xl">
              Everything you need, already in place
            </h2>
            <p className="mt-4 font-sans text-base leading-relaxed text-charcoal/80 md:text-lg">
              A refined environment with the practical essentials of a modern
              business center — ready for day one.
            </p>
            <ul className="mt-10 grid gap-3 sm:grid-cols-2">
              {AMENITIES.map((item) => (
                <li
                  key={item}
                  className="border-l-2 border-gold/70 pl-4 font-sans text-sm text-charcoal/85 md:text-[0.95rem]"
                >
                  {item}
                </li>
              ))}
            </ul>
          </div>
        </div>
      </section>
    </>
  );
}
