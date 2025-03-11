import fs from 'fs/promises'
import path from 'path'
import bcrypt from 'bcryptjs'

export default defineEventHandler(async (event) => {
  try {
    const body = await readBody(event)
    const { username, password } = body

    if (!username || !password) {
      return { success: false, error: 'Username and password are required!' }
    }

    const normalizedUsername = username.trim().toLowerCase()
    const filePath = path.resolve('server/data/people.json')

    let users = []
    try {
      const fileData = await fs.readFile(filePath, 'utf-8')
      users = fileData ? JSON.parse(fileData) : []
    } catch (error) {
      console.warn('No existing users file found.')
    }

    const user = users.find(u => u.username === normalizedUsername)

    if (!user) {
      return { success: false, error: 'Invalid username or password!' }
    }

    const passwordMatch = await bcrypt.compare(password, user.password)

    if (!passwordMatch) {
      return { success: false, error: 'Invalid username or password!' }
    }

    return { success: true, message: 'Login successful!' }
  } catch (error) {
    console.error('Login Error:', error)
    return { success: false, error: 'Something went wrong, please try again.' }
  }
})
