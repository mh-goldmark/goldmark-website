const FOOTER_LINKS = [
  { href: "#workspaces", label: "Workspaces" },
  { href: "#services", label: "Services" },
  { href: "#amenities", label: "Amenities" },
  { href: "#about", label: "About" },
  { href: "#contact", label: "Contact" },
] as const;

export default function Footer() {
  return (
    <footer className="border-t border-white/10 bg-[#081526] py-12">
      <div className="mx-auto flex max-w-[1440px] flex-col gap-8 px-5 md:flex-row md:items-end md:justify-between md:px-8 lg:px-10">
        <div>
          <p className="font-heading text-xl text-gold">Gold Mark Work Life</p>
          <p className="mt-2 font-sans text-sm tracking-[0.08em] text-beige/70">
            Business Center LLC · Cityland Mall, Dubai
          </p>
        </div>
        <nav className="flex flex-wrap gap-x-6 gap-y-3" aria-label="Footer">
          {FOOTER_LINKS.map((link) => (
            <a
              key={link.href}
              href={link.href}
              className="font-sans text-sm text-off-white/75 transition hover:text-gold"
            >
              {link.label}
            </a>
          ))}
        </nav>
      </div>
      <div className="mx-auto mt-10 max-w-[1440px] px-5 md:px-8 lg:px-10">
        <p className="font-sans text-xs text-white/40">
          © 2026 Gold Mark Work Life Business Center LLC.
          All rights reserved.
        </p>
      </div>
    </footer>
  );
}
