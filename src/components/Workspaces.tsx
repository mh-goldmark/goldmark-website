const WORKSPACES = [
  {
    id: "private-offices",
    title: "Private Offices & Agency Suites",
    copy: "Secure, furnished suites sized for growing teams — crafted for focus, client meetings, and a polished Dubai presence.",
  },
  {
    id: "coworking",
    title: "Coworking & Dedicated Desks",
    copy: "Flexible memberships with premium seating, reliable connectivity, and a professional atmosphere without long leases.",
  },
  {
    id: "meeting-rooms",
    title: "Meeting & Training Rooms",
    copy: "Presentation-ready rooms with AV support for board sessions, workshops, and client pitches — bookable on demand.",
  },
] as const;

export default function Workspaces() {
  return (
    <section
      id="workspaces"
      className="relative bg-off-white py-20 text-charcoal md:py-28"
    >
      <div className="mx-auto max-w-[1440px] px-5 md:px-8 lg:px-10">
        <div className="max-w-2xl">
          <p className="font-sans text-xs font-semibold uppercase tracking-[0.24em] text-gold">
            Workspaces
          </p>
          <h2 className="mt-3 font-heading text-3xl leading-tight text-navy md:text-4xl lg:text-[2.75rem]">
            Spaces designed for how Dubai works
          </h2>
          <p className="mt-4 max-w-xl font-sans text-base leading-relaxed text-charcoal/80 md:text-lg">
            From private suites to collaborative desks and training rooms —
            choose the setting that matches your next chapter.
          </p>
        </div>

        <div className="mt-14 grid gap-10 border-t border-navy/10 pt-12 md:grid-cols-3 md:gap-12">
          {WORKSPACES.map((item, index) => (
            <article key={item.id} className="group">
              <span className="font-sans text-xs font-semibold tracking-[0.2em] text-gold">
                0{index + 1}
              </span>
              <h3 className="mt-3 font-heading text-2xl text-navy transition-colors duration-300 group-hover:text-gold md:text-[1.65rem]">
                {item.title}
              </h3>
              <p className="mt-3 font-sans text-[0.95rem] leading-relaxed text-charcoal/75">
                {item.copy}
              </p>
              <a
                href="#contact"
                className="mt-5 inline-flex items-center gap-2 font-sans text-sm font-semibold tracking-[0.06em] text-navy transition hover:text-gold"
              >
                Enquire
                <span aria-hidden className="transition group-hover:translate-x-1">
                  →
                </span>
              </a>
            </article>
          ))}
        </div>
      </div>
    </section>
  );
}
