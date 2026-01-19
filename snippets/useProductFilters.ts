import { useMemo } from 'react'
import type { Product } from '../data/products'

export type ProductFilters = {
  category: string
  brand: string
  size: string
  gender: string
  year: number | null
  minPrice: number | null
  maxPrice: number | null
  inStockOnly: boolean
  query: string
}

export function useProductFilters(
  products: Product[],
  { category, brand, size, gender, year, minPrice, maxPrice, inStockOnly, query }: ProductFilters,
): Product[] {
  return useMemo(() => {
    const normalizedQuery = query.trim().toLowerCase()

    return products.filter((product) => {
      if (category !== 'All' && product.category !== category) return false
      if (brand !== 'All' && product.brand !== brand) return false
      if (size !== 'All' && product.size !== size) return false
      if (gender !== 'All' && product.gender !== gender) return false
      if (year !== null && product.year !== year) return false
      if (inStockOnly && product.in_stock <= 0) return false

      if (minPrice !== null && product.price_in_pounds < minPrice) return false
      if (maxPrice !== null && product.price_in_pounds > maxPrice) return false

      if (normalizedQuery) {
        const name = `${product.brand} ${product.model}`.toLowerCase()
        if (!name.includes(normalizedQuery)) return false
      }

      return true
    })
  }, [products, category, brand, size, gender, year, minPrice, maxPrice, inStockOnly, query])
}
