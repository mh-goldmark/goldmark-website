import Image from "next/image";

const FEATURES = [
  {
    label: "Private Offices",
    icon: (
      <svg viewBox="0 0 32 32" className="h-7 w-7" fill="none" aria-hidden>
        <rect x="5" y="7" width="22" height="18" rx="1.5" stroke="currentColor" strokeWidth="1.5" />
        <path d="M5 12h22M13 12v13" stroke="currentColor" strokeWidth="1.5" />
        <path d="M16.5 17.5h4M16.5 21h4" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" />
      </svg>
    ),
  },
  {
    label: "Coworking",
    icon: (
      <svg viewBox="0 0 32 32" className="h-7 w-7" fill="none" aria-hidden>
        <circle cx="10" cy="11" r="3" stroke="currentColor" strokeWidth="1.5" />
        <circle cx="22" cy="11" r="3" stroke="currentColor" strokeWidth="1.5" />
        <path
          d="M5.5 24c.6-3.2 2.7-5 4.5-5s3.9 1.8 4.5 5M17.5 24c.6-3.2 2.7-5 4.5-5s3.9 1.8 4.5 5"
          stroke="currentColor"
          strokeWidth="1.5"
          strokeLinecap="round"
        />
      </svg>
    ),
  },
  {
    label: "Meeting Rooms",
    icon: (
      <svg viewBox="0 0 32 32" className="h-7 w-7" fill="none" aria-hidden>
        <rect x="6" y="10" width="20" height="11" rx="1.5" stroke="currentColor" strokeWidth="1.5" />
        <path d="M10 21v3M22 21v3M8 25h16" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" />
        <path d="M11 15h10" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" />
      </svg>
    ),
  },
  {
    label: "Training Facilities",
    icon: (
      <svg viewBox="0 0 32 32" className="h-7 w-7" fill="none" aria-hidden>
        <path
          d="M6 12.5 16 8l10 4.5L16 17 6 12.5Z"
          stroke="currentColor"
          strokeWidth="1.5"
          strokeLinejoin="round"
        />
        <path d="M10 14.5v5.2c0 .4 2.6 2.3 6 2.3s6-1.9 6-2.3v-5.2" stroke="currentColor" strokeWidth="1.5" />
        <path d="M26 12.5V19" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" />
      </svg>
    ),
  },
  {
    label: "Business Support",
    icon: (
      <svg viewBox="0 0 32 32" className="h-7 w-7" fill="none" aria-hidden>
        <path
          d="M9 13h14v11H9V13Z"
          stroke="currentColor"
          strokeWidth="1.5"
          strokeLinejoin="round"
        />
        <path d="M12 13V10.5A4 4 0 0 1 16 6.5a4 4 0 0 1 4 4V13" stroke="currentColor" strokeWidth="1.5" />
        <path d="M16 17.5v3" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" />
      </svg>
    ),
  },
] as const;

export default function Hero() {
  return (
    <section
      id="home"
      className="relative isolate min-h-[calc(100svh-4.5rem)] overflow-hidden md:min-h-[calc(100svh-5rem)]"
    >
      <div className="absolute inset-0">
        <Image
          src="/images/hero-lounge.jpg"
          alt="Luxury business lounge and private offices at Gold Mark Work Life"
          fill
          priority
          sizes="100vw"
          className="animate-ken-burns object-cover object-[68%_center] md:object-right"
        />
        <div className="absolute inset-0 bg-gradient-to-r from-navy via-navy/92 to-navy/25 md:via-navy/78 md:to-transparent" />
        <div className="absolute inset-0 bg-gradient-to-t from-navy/80 via-transparent to-navy/35 md:from-navy/55" />
      </div>

      <div className="relative mx-auto flex min-h-[calc(100svh-4.5rem)] max-w-[1440px] flex-col justify-between px-5 pb-8 pt-16 md:min-h-[calc(100svh-5rem)] md:px-8 md:pb-10 md:pt-20 lg:px-10 lg:pt-24">
        <div className="max-w-xl text-center md:max-w-[34rem] md:text-left lg:max-w-[38rem]">
          <p className="animate-fade-up font-sans text-[0.7rem] font-semibold uppercase tracking-[0.28em] text-gold md:text-xs">
            Gold Mark Work Life
          </p>
          <div className="animate-draw-line mt-4 h-px w-16 bg-gold mx-auto md:mx-0" />
          <h1 className="animate-fade-up delay-1 mt-6 font-heading text-[2.55rem] leading-[1.08] tracking-tight text-off-white sm:text-5xl md:text-[3.35rem] lg:text-[3.75rem]">
            Your Business.
            <br />
            Your Space.
            <br />
            <span className="text-[#D4AF37]">Your Future.</span>
          </h1>
          <p className="animate-fade-up delay-2 mt-5 font-sans text-base font-medium leading-relaxed text-beige/95 md:text-lg">
            Premium Business Center at Cityland Mall, Dubai
          </p>
          <div className="animate-fade-up delay-3 mt-9 flex flex-col items-stretch gap-3 sm:flex-row sm:items-center sm:justify-center md:justify-start">
            <a
              href="#contact"
              className="inline-flex items-center justify-center rounded-md bg-gold px-7 py-3.5 font-sans text-sm font-semibold tracking-[0.06em] text-navy transition duration-300 hover:bg-[#e0c04a]"
            >
              Book a Tour
            </a>
            <a
              href="#contact"
              className="inline-flex items-center justify-center rounded-md border border-off-white/85 px-7 py-3.5 font-sans text-sm font-semibold tracking-[0.06em] text-off-white transition duration-300 hover:border-gold hover:text-gold"
            >
              Get a Quote
            </a>
          </div>
        </div>

        <ul className="animate-fade-up delay-4 mt-16 grid grid-cols-2 gap-x-4 gap-y-6 border-t border-white/15 pt-7 sm:grid-cols-3 md:mt-0 md:grid-cols-5 md:gap-6 md:border-white/20 md:pt-8">
          {FEATURES.map((feature) => (
            <li
              key={feature.label}
              className="flex flex-col items-center gap-2.5 text-center text-off-white/95"
            >
              <span className="text-off-white/90">{feature.icon}</span>
              <span className="font-sans text-[0.68rem] font-medium uppercase tracking-[0.12em] sm:text-[0.72rem]">
                {feature.label}
              </span>
            </li>
          ))}
        </ul>
      </div>
    </section>
  );
}
