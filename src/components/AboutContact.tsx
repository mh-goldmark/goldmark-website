import ContactForm from "./ContactForm";

export default function AboutContact() {
  return (
    <>
      <section id="about" className="bg-off-white py-20 text-charcoal md:py-28">
        <div className="mx-auto max-w-[1440px] px-5 md:px-8 lg:px-10">
          <div className="grid gap-10 lg:grid-cols-[1.1fr_0.9fr] lg:gap-20">
            <div>
              <p className="font-sans text-xs font-semibold uppercase tracking-[0.24em] text-gold">
                About
              </p>
              <h2 className="mt-3 font-heading text-3xl leading-tight text-navy md:text-4xl lg:text-[2.75rem]">
                A premium address for ambitious teams
              </h2>
              <p className="mt-5 max-w-2xl font-sans text-base leading-relaxed text-charcoal/80 md:text-lg">
                Gold Mark Work Life Business Center LLC brings a refined
                workspace experience to Cityland Mall — combining private
                offices, coworking, and meeting facilities with attentive
                business support in the heart of Dubai.
              </p>
            </div>
            <aside className="border-t border-navy/10 pt-8 lg:border-l lg:border-t-0 lg:pl-12 lg:pt-2">
              <p className="font-sans text-xs font-semibold uppercase tracking-[0.2em] text-navy/60">
                Location
              </p>
              <p className="mt-3 font-heading text-2xl text-navy">
                Cityland Mall · Shop 274
              </p>
              <p className="mt-2 font-sans text-base text-charcoal/75">
                Dubai, United Arab Emirates
              </p>
              <p className="mt-6 font-sans text-sm leading-relaxed text-charcoal/70">
                Pre-opening registrations and private tours are open. Inventory
                details will be confirmed with management prior to launch.
              </p>
            </aside>
          </div>
        </div>
      </section>

      <section
        id="contact"
        className="relative overflow-hidden bg-navy py-20 md:py-28"
      >
        <div
          className="pointer-events-none absolute inset-0 opacity-40"
          style={{
            background:
              "radial-gradient(ellipse 70% 60% at 80% 20%, rgba(212,175,55,0.18), transparent 60%)",
          }}
        />
        <div className="relative mx-auto max-w-[1440px] px-5 md:px-8 lg:px-10">
          <div className="mx-auto max-w-2xl text-center">
            <p className="font-sans text-xs font-semibold uppercase tracking-[0.24em] text-gold">
              Contact
            </p>
            <h2 className="mt-3 font-heading text-3xl leading-tight text-off-white md:text-4xl">
              Book a tour or request a quote
            </h2>
            <p className="mt-4 font-sans text-base leading-relaxed text-beige/85 md:text-lg">
              Tell us about your team size and preferred workspace. Our team
              will respond with availability and next steps.
            </p>
          </div>
          <ContactForm />
        </div>
      </section>
    </>
  );
}
