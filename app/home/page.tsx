import Header from "@/components/header"
import Hero from "@/components/hero"
import FeaturedProducts from "@/components/featured-products"
import Categories from "@/components/categories"
import Footer from "@/components/footer"
import Testimonials from "@/components/testimonials"
import Newsletter from "@/components/newsletter"
import BrandStory from "@/components/brand-story"
import Stats from "@/components/stats"

export default function Home() {
  return (
    <div className="min-h-screen bg-white">
      <Header />
      <main>
        <Hero />
        <Stats />
        <Categories />
        <FeaturedProducts />
        <BrandStory />
        <Testimonials />
        <Newsletter />
      </main>
      <Footer />
    </div>
  )
}
